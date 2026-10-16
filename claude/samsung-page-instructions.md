# Instructions for Claude Code: add the Samsung brand page

You are adding ONE new page to the fridgerepairparramatta.com.au static site (Hostinger, Tailwind CDN, styles.css, app.js). Everything for the page is in `samsung-fridge-repair-parramatta.html`. The JSON-LD schema is already inside it.

## 1. Create the page
- Target URL: `/brands/samsung-fridge-repair-parramatta` (canonical `https://fridgerepairparramatta.com.au/brands/samsung-fridge-repair-parramatta`).
- **Match the repo's routing.** The live site uses flat URLs (for example `/fridge-not-cooling-repair`, `/fridge-regas`). Look at how the existing pages are stored and served. If the site does not support `/brands/<slug>`, use the nearest equivalent (for example `/samsung-fridge-repair-parramatta`) and then update the canonical, `og:url`, the schema (`@id`, `url`, breadcrumb item) and the sitemap to match. Do not leave the old URL anywhere.
- Copy an existing inner page (for example the `/fridge-not-cooling-repair` page) and use it as the shell:
  1. Take its shared `<head>` assets (favicon, fonts, styles.css, app.js, analytics) and put them where the `CLAUDE CODE` comment is in my `<head>`.
  2. Take its header/nav and put it at the first `CLAUDE CODE` comment in `<body>`.
  3. Take its footer and scripts and put them at the last `CLAUDE CODE` comment.
  4. Keep my `<title>`, meta description, canonical, Open Graph tags, the `<style>` block and the JSON-LD exactly as they are. Remove the `CLAUDE CODE` comments when done.
- The content is wrapped in `<main class="sfr">`. All CSS is scoped to `.sfr`, so it will not break the rest of the site. Do not rewrite the copy. If you want to match the site's brand colours, change only the CSS variables at the top of the `<style>` block (`--sfr-accent`, `--sfr-dark`).
- The page has no images on purpose (fast load). Don't add stock photos.

## 2. Internal links to add on OTHER pages (so the page is not an orphan)
- `/brands`: link the Samsung card or entry to this page with the anchor "Samsung fridge repair Parramatta".
- Homepage brands section and the footer brands list: link "Samsung" to this page.
- `/fridge-repair-cost`: where Samsung is mentioned, link "Samsung fridge repair cost" to this page.
- `/fridge-not-cooling-repair`: in the brands section, link "Samsung" to this page.
- Do not link to pages that don't exist yet (LG, Fisher & Paykel and other brand pages). They are plain text for now.

## 3. Sitemap
Add this URL to `sitemap.xml` with `lastmod` set to the real date you publish. Only add it once it returns 200.

## 4. Check before you push
- Page loads with no console errors, no horizontal scroll at 360, 390, 768 and 1280 px wide.
- JSON-LD passes validator.schema.org and Google's Rich Results Test. The FAQ text on the page matches the schema exactly (it was generated from the same source).
- Title is 56 characters, meta description is 150 (both within limits). One H1 only.
- All internal links return 200.
- Then commit and push. Suggested message: `Add Samsung fridge repair Parramatta brand page`.

## 5. Things the owner must still fill in (not in the code, tell the user)
- ARCtick number and a visible licence line (the page says "ARC-licensed"; add the number where the site shows its licence).
- A phone number. There is none on the site. Once there is one, add a Call button to the sticky mobile bar (`.sfr-bar`) and the hero with a `tel:` link.
- Confirm the prices in the price table against real invoices.
- Add real, verified Samsung reviews and a photo of a real technician if available. Do not add aggregateRating without visible reviews.

## Reference (do not change in code)
- Primary keyword: samsung fridge repair parramatta (title, H1, intro, CTA, FAQ 1).
- Secondary keywords used naturally: samsung fridge repairs, samsung fridge not cooling, samsung french door / side-by-side / family hub, samsung fridge error codes, samsung ice maker not working, samsung fridge repair cost.
- Alternative titles (A/B test later): (1) Samsung Fridge Repair Parramatta | Local Licensed Techs  (2) Samsung Fridge Not Working? Parramatta Repair, Fixed Quote
- Alternative meta descriptions: (1) Samsung fridge repairs in Parramatta from local ARC-licensed techs. Real prices, error code help and a 1-year warranty. Book online in 2 minutes.  (2) Fix your Samsung fridge fast. Not cooling, ice maker, leaks and error codes sorted by Parramatta techs. See prices, then book online 24/7.
