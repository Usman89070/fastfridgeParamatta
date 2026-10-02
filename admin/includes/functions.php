<?php
/**
 * Small shared helpers: HTML escaping, slug generation, CSRF tokens, and an
 * allowlist HTML sanitizer for admin-authored post content.
 */

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Reads an uploaded image's real pixel dimensions so callers can emit
 * width/height attributes (prevents layout shift while it loads). Takes a
 * site-relative path (as stored in blog_posts.featured_image); returns
 * ' width="123" height="456"' ready to drop straight into an <img> tag, or
 * an empty string if the file can't be read.
 */
function image_dimensions_attr(string $siteRelativePath): string {
    $path = __DIR__ . '/../../' . ltrim($siteRelativePath, '/');
    $size = @getimagesize($path);
    if ($size === false) {
        return '';
    }
    return ' width="' . (int) $size[0] . '" height="' . (int) $size[1] . '"';
}

function slugify(string $text): string {
    $text = mb_strtolower(trim($text), 'UTF-8');
    // Transliterate common accented characters (é, ü, etc.) to plain ASCII.
    $transliterated = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    if ($transliterated !== false) {
        $text = $transliterated;
    }
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    $text = preg_replace('/-+/', '-', $text);
    return $text !== '' ? $text : 'post';
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): void {
    $submitted = $_POST['csrf_token'] ?? '';
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $submitted)) {
        http_response_code(403);
        die('Security check failed (invalid or expired form token). Go back, refresh the page, and try again.');
    }
}

/**
 * Strip post content down to a safe allowlist of tags/attributes before it
 * is stored. The admin panel is single-user and trusted, but this is cheap
 * defense-in-depth against a compromised admin password or a mistaken paste
 * of a <script> tag from somewhere else.
 */
function sanitize_post_content(string $html): string {
    if (trim($html) === '') {
        return '';
    }

    $allowedTags = [
        'p', 'h2', 'h3', 'h4', 'ul', 'ol', 'li', 'strong', 'em', 'b', 'i',
        'a', 'br', 'blockquote', 'div', 'img', 'span',
    ];
    $allowedAttrsByTag = [
        'a' => ['href', 'title'],
        'div' => ['class'],
        'img' => ['src', 'alt', 'class'],
        'span' => ['class'],
    ];

    $wrapped = '<?xml encoding="utf-8"?><div id="__root__">' . $html . '</div>';
    $doc = new DOMDocument();
    $prevErrors = libxml_use_internal_errors(true);
    $doc->loadHTML($wrapped, LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();
    libxml_use_internal_errors($prevErrors);

    $root = $doc->getElementById('__root__');
    if (!$root) {
        return '';
    }

    clean_dom_node($root, $allowedTags, $allowedAttrsByTag);

    $out = '';
    foreach (iterator_to_array($root->childNodes) as $child) {
        $out .= $doc->saveHTML($child);
    }
    return trim($out);
}

/**
 * Deletes a stored featured-image file given its site-relative path (as
 * saved in blog_posts.featured_image), refusing to touch anything outside
 * /image/blog/.
 */
function delete_featured_image_file(string $relativePath): void {
    $path = __DIR__ . '/../../' . $relativePath;
    $blogImageDir = realpath(__DIR__ . '/../../image/blog');
    $real = realpath($path);
    if ($real && $blogImageDir && str_starts_with($real, $blogImageDir)) {
        @unlink($real);
    }
}

function clean_dom_node(DOMNode $node, array $allowedTags, array $allowedAttrsByTag): void {
    $children = iterator_to_array($node->childNodes);
    foreach ($children as $child) {
        if ($child->nodeType === XML_TEXT_NODE) {
            continue;
        }
        if ($child->nodeType !== XML_ELEMENT_NODE) {
            $node->removeChild($child);
            continue;
        }

        /** @var DOMElement $child */
        $tag = strtolower($child->tagName);

        // These carry non-prose payloads (code, embeds) - discard entirely,
        // don't unwrap their contents as visible text.
        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'noscript'], true)) {
            $node->removeChild($child);
            continue;
        }

        if (!in_array($tag, $allowedTags, true)) {
            // Unwrap other disallowed tags (keep their text/children) rather
            // than dropping the content entirely - safer default for a
            // paste-in from a word processor or another site.
            while ($child->firstChild) {
                $node->insertBefore($child->firstChild, $child);
            }
            $node->removeChild($child);
            continue;
        }

        // Strip every attribute except the small allowlist for this tag.
        $allowedAttrs = $allowedAttrsByTag[$tag] ?? [];
        foreach (iterator_to_array($child->attributes ?? []) as $attr) {
            $name = strtolower($attr->name);
            if (!in_array($name, $allowedAttrs, true)) {
                $child->removeAttribute($attr->name);
                continue;
            }
            if ($name === 'href' || $name === 'src') {
                $value = trim($attr->value);
                $lower = strtolower($value);
                if (str_starts_with($lower, 'javascript:') || str_starts_with($lower, 'data:')) {
                    $child->removeAttribute($attr->name);
                }
            }
        }
        if ($tag === 'a') {
            $child->setAttribute('rel', 'noopener');
        }

        clean_dom_node($child, $allowedTags, $allowedAttrsByTag);
    }
}
