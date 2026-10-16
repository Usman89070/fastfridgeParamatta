# fridgerepairparramatta.com.au: project memory

Static HTML site plus a small PHP/MySQL blog admin, deployed to Hostinger by GitHub Actions (FTP). See HOSTINGER_DEPLOYMENT.md.

## Daily page routine (important)
The owner does not want to say each day which page to build.
1. Read `claude/page-progress.md`. Find the first page marked TO DO in its build order.
2. Tell the owner in one line: "Today's page: <name> (<URL>, primary keyword <kw>)", then build it.
3. Use `claude/keyword-strategy.md` for that page's title, meta, H1, keywords, notes and competitors.
4. Follow `claude/content-standard.md` and `claude/website-context.md` (Australian English, no em dashes, no AI tells, no invented reviews, stats, phone or ARCtick numbers, no senior discount, prices must match /fridge-repair-cost).
5. When the page is done: update `claude/page-progress.md` (status plus log line), add links to it from related live pages, add it to the sitemap and `.htaccess`, commit and push to the branch you were given.

## Site rules
- Flat URLs only (`/fridge-regas`, `/lg-fridge-repair`). The keyword sheet's `/services/...`, `/commercial/...`, `/brands/...` URLs are not used; the flat mapping is in `claude/keyword-strategy.md`.
- Each page is a root `*.html` file. New page = copy the site's header/footer from an existing page, add the route to `.htaccess` (both lists), add its priority to `sitemap.php`.
- `tailwind-built.css` is precompiled. After adding new Tailwind classes run `cd .buildtools && npm ci && npx tailwindcss -i input.css -o ../tailwind-built.css --minify`.
- No phone number exists on the site, so never add a tel: link. No ARCtick number is known: use the owner's wording ("ARCtick licensed & verified" or "ARC-licensed") and no number. Lic #R38910 is on the site.
- Pages so far: regas, Samsung, LG. Everything else is tracked in `claude/page-progress.md`.
- Never push to `main` unless asked. Pushing a `claude/**` branch also deploys to the live site.
