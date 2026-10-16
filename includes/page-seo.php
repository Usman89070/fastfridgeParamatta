<?php
/**
 * Loads per-page SEO overrides (title, meta description, canonical, H1,
 * OG tags, robots meta, JSON-LD schema) from the `pages` table, for static
 * marketing pages converted to pull from the SEO admin panel.
 *
 * Deliberately defensive: static pages must keep rendering exactly as
 * before even if the database is unreachable, the `pages` table hasn't
 * been migrated in yet, or config.php doesn't exist - none of that is
 * reason enough to break pages that previously had zero DB dependency.
 * Any failure silently falls back to the $defaults the caller supplies.
 *
 * @param string $slug     Row to look up in `pages.slug`.
 * @param array  $defaults Current hardcoded values, used whenever a field
 *                         has no DB override (or the DB can't be reached).
 *                         Expected keys: title, meta_description,
 *                         canonical_url, h1, og_title, og_description,
 *                         robots_meta, schema (an array to json_encode).
 * @return array Same shape as $defaults, with DB overrides applied.
 */
function get_page_seo(string $slug, array $defaults): array {
    $result = $defaults;

    $configFile = __DIR__ . '/../admin/includes/config.php';
    if (!file_exists($configFile)) {
        return $result;
    }

    try {
        require_once __DIR__ . '/../admin/includes/db.php';
        $stmt = get_db()->prepare('SELECT * FROM pages WHERE slug = ?');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        if (!$row) {
            return $result;
        }

        foreach (['title', 'meta_description', 'canonical_url', 'h1', 'og_title', 'og_description', 'robots_meta'] as $key) {
            if (!empty($row[$key])) {
                $result[$key] = $row[$key];
            }
        }

        if (!empty($row['schema_json'])) {
            $decoded = json_decode($row['schema_json'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $result['schema'] = $decoded;
            }
        }
    } catch (Throwable $e) {
        // DB unreachable, table not migrated yet, bad credentials, etc. -
        // the page still has to render, so just keep the defaults.
    }

    return $result;
}
