# fridgerepairparramatta.com.au: Website Context (master file)

Last updated: 15 Oct 2026 (log of page content: claude/page-content-log.md and claude/page-content-log-2.md). Read this instead of crawling the site. Update it after every site change.

## 1. Business
- Name: Fridge Repair Parramatta (independent repairer, not affiliated with any brand)
- Services: residential and commercial fridge, freezer, coolroom, regas, ice machine, and display/salad bar repairs
- Area: Parramatta 2150 plus nearby Western Sydney suburbs. The domain is an exact match for Parramatta, so content stays Parramatta-focused. Commercial pages may also say "Parramatta & Sydney".
- Licence: Lic #R38910 (shown on /about; still needs confirming). ARCtick number: [missing]
- Email: info@fridgerepairparramatta.com.au. **Phone: NONE ON SITE (critical gap)**
- Address in schema: "Church Street, Parramatta NSW 2150" (no street number)
- Claims on the site:
  - 30+ years' experience
  - 1-year parts and labour warranty
  - Same-day service, 24/7 emergency
  - Free quotes, "No hidden call-outs"
- The user asked for no senior discount mentions in new content. The homepage still lists them, so remove those.
- Unverified homepage claims to fix:
  - "~45 min avg response" and "Dispatch ONLINE"
  - "5.0 / 128 reviews" in the schema, with no reviews shown on the site

## 2. Tech stack
- Static HTML site on Hostinger (hCDN, Brotli, HTTP/2)
- Tailwind Play CDN (must be compiled for production), lucide@latest from unpkg
- app.js?v=9, styles.css?v=3
- Forms POST to /send-inquiry.php via JS; the HTML fallback is method=get
- 404 page is the Hostinger default
- Schema: HVACBusiness (incomplete)
- Design system:
  - Dark slate hero (with breadcrumb on inner pages)
  - White and slate-50 alternating sections
  - 3-column cards with H3s
  - Numbered steps 01–06
  - Tables, FAQ accordion, suburb chips
  - Dark CTA band
  - Booking modal (4 steps) and Quote Estimator modal

## 3. Live URLs and status (checked 8 Oct 2026)
| URL | Status |
|---|---|
| / | 200. H1 "Fridge Repair Parramatta"; ~4,600 words; sections listed below |
| /about | 200 |
| /contact | 200 |
| /blog | 200. Lists 3 posts |
| /blog-fridge-not-cooling-causes | **500 error** |
| /blog-repair-or-replace-guide | **500 error** |
| /blog-summer-fridge-maintenance-tips | **500 error** |
| /fridge-repair-parramatta/ | Duplicate of / with 200. Needs a 301 to / |
| www.* | No redirect to non-www |
| /about/ vs /about | Both 200. Needs a trailing-slash 301 |
| /index.html | Redirects (OK) |
| /admin, /.env, /.git | 403 (OK) |

**Homepage sections, in order:**
1. Ticker
2. Hero with form
3. Reviews (5)
4. Why us (12 cards)
5. Local experts
6. Services (7)
7. Common faults (13)
8. Diagnosis steps
9. Emergency 24/7
10. Brands
11. Industries
12. Process (6)
13. Repair vs replace table and calculator
14. Maintenance tips
15. Suburbs (30)
16. FAQs (15)
17. Blog (3)
18. CTA
19. Footer

**Nav:** anchor links only (/#services, /#brands, …). There are no real service pages yet.

## 3b. Live check on 14 Oct 2026 (sitemap and new pages)
- The developer has published a sitemap with 14 URLs: /, /about, /services, /fridge-not-cooling-repair, /fridge-repair-cost, /emergency-fridge-repair, /brands, /blog, the 3 old-slug blog posts (/blog-fridge-not-cooling-causes, /blog-repair-or-replace-guide, /blog-summer-fridge-maintenance-tips), /contact, /privacy-policy, /terms-of-service. robots.txt allows everything and points to it.
- **URL change:** the not-cooling page is live at /fridge-not-cooling-repair (flat), not /services/fridge-not-cooling-repair as planned. Its title and H1 differ slightly from the content doc. It still has an "ARC refrigerant handling licence [confirm number]" placeholder and links to /blog-summer-fridge-maintenance-tips.
- The three blog posts now list in /blog with the new titles, still on the old flat slugs.
- NOT live (could not be fetched): /services/fridge-regas, /commercial/commercial-fridge-repair, /commercial/coolroom-repair. Add them to the sitemap only once live. Final URLs may be flat too.
- The sitemap lastmod on most pages is 2026-10-14. Use real edit dates, or Google may ignore it.

## 4. Open technical issues (from the 28 Sep audit, IDs E01–E31)
- **Critical:**
  - Crawler timeouts
  - No phone number or tel: link
  - Duplicate homepage URL
  - Sitemap lists only 2 URLs, both the homepage
  - **3 blog posts return 500 errors (found 8 Oct)**
- **High:**
  - www and trailing-slash redirects
  - Tailwind CDN
  - lucide@latest
  - Hash nav with no service pages
  - Incomplete schema
  - aggregateRating without visible reviews
- **Medium/low:**
  - Default 404 page
  - Forms fall back to GET
  - No HSTS
  - No GA4
  - No og:image
  - Blog posts have no Article schema
  - Small tap targets
  - X-Powered-By header exposed

## 5. Search Console (via Supermetrics, property sc-domain:fridgerepairparramatta.com.au)
- Data from 20 Sep to 1 Oct 2026: 130 impressions, 2 clicks, average position ~38
- Only / and /about get impressions. No sitemap has been submitted.
- Ranking well already:

  | Query | Position |
  |---|---|
  | emergency commercial refrigeration repair | #3 |
  | fridge repairs near me | #2 |
  | 24 hour fridge repair | #4 |
  | urgent fridge repair | #7 |

- Main keywords:

  | Query | Position |
  |---|---|
  | fridge repair parramatta | #24.5 |
  | fridge repairs parramatta | #52 |
  | commercial fridge repair | #85 |

## 6. Strategy (agreed direction)
- A focused plan of **about 25 pages**, all Parramatta-led, instead of the original 88:
  - Core: Home, Emergency, Cost, Services hub, Brands hub
  - 6 services: not cooling, regas, compressor, seals, freezer, thermostat/board
  - Commercial: commercial hub and coolroom. Ice machine and display pages moved earlier, based on Search Console.
  - 5 brands: Samsung, LG, Fisher & Paykel, Westinghouse, Electrolux
  - 5 suburbs: North Parramatta, Harris Park, Westmead, Rosehill, Granville
  - About 6 blog posts
- Order of priority:
  1. Technical fixes
  2. Google Business Profile and reviews
  3. Homepage
  4. Core pages
  5. Service and commercial pages
  6. Brand, suburb and blog pages
- Planned URL structure:
  - /services/<service>
  - /commercial/<page>
  - /brands/<brand>-fridge-repair
  - /areas/fridge-repair-<suburb>
  - /blog/<slug>
  - /fridge-repair-cost
  - /emergency-fridge-repair
- Price ranges used across all content (Sydney, incl. GST; confirm against real invoices):

  | Item | Range |
  |---|---|
  | Typical repair | $150–$450 |
  | Call-out fee | $60–$200 |
  | Seal | $120–$300 |
  | Thermostat | $150–$300 |
  | Relay | $120–$250 |
  | Fan | $180–$400 |
  | Defrost | $150–$350 |
  | Control board | $250–$600 |
  | Regas | $250–$600 |
  | Compressor | $450–$1,100 |
  | Commercial call-out | $100–$250 |
  | Coolroom repairs | $250–$900 |

## 7. Content written (Word files; not yet live)
| Page / URL | Primary keyword | Date |
|---|---|---|
| /emergency-fridge-repair | emergency fridge repair parramatta | 29 Sep |
| /fridge-repair-cost | fridge repair cost sydney | 29 Sep |
| /services | fridge repair services parramatta | 30 Sep |
| /brands | fridge brands we repair parramatta (+ Teco, TCL, Vintec, Kogan, GE, Simpson, Siemens) | 1 Oct |
| /blog/fridge-not-cooling (replaces the old post) | fridge not cooling | 1 Oct |
| /blog/repair-or-replace-fridge | is it worth repairing a fridge | 8 Oct |
| /blog/summer-fridge-maintenance-tips | fridge maintenance tips | 8 Oct |
| /services/fridge-not-cooling-repair | fridge not cooling repair parramatta (+ condenser and evaporator repair) | 9 Oct |
| /services/fridge-regas | fridge regas parramatta (+ gas recharge, gas refill, gas leak repair) | 9 Oct |
| /commercial/commercial-fridge-repair (hub, with JSON-LD schema) | commercial fridge repair parramatta (+ commercial refrigeration, freezer, cafe, restaurant, Skope, Bromic, Williams, F.E.D.) | 12 Oct |
| /commercial/coolroom-repair (with JSON-LD schema) | coolroom repair parramatta (+ walk-in freezer, freezer room, installation [unconfirmed], Western Sydney) | 12 Oct |

Not written yet: homepage rewrite, remaining commercial spokes (ice machine, display fridge), other service pages (compressor, seals, freezer, thermostat/board), commercial pages, brand pages, suburb pages.

## 8. Writing rules (user preferences)
**Master standard for every page and blog: read claude/content-standard.md. The user will not repeat these instructions.**

- Australian English, human tone, no em dashes and no "AI-sounding" phrases
- No senior discount mentions
- No fake reviews, stats or claims. Use [placeholders] for unknowns: phone, fees, ARCtick, technician name.
- Each page is delivered as a .docx with:
  - SEO set-up: URL, title ≤60, meta ≤155, H1, schema, alt text, links
  - Labelled sections matching the site design
  - FAQs
  - A pre-publish checklist
- Secondary keywords come from competitors. There's no Semrush KD access here, so the user verifies KD in Semrush (AU).

## 8b. STANDARD FOR EVERY NEW PAGE OR BLOG (saved 15 Oct 2026; the user must not repeat these)
1. Analyse the top 10 competitors ranking in Australia and Sydney (and Parramatta) for the primary keyword. Live-fetch them. If a page can't be fetched, say so in the competitor table. Never invent data. Write content clearly better than theirs.
2. Complete, AI-search optimised (direct answer box, FAQs, entities), Google-friendly and user-friendly.
3. Human-written tone. No AI signs or marks: no em dashes, no filler openers, no "genuinely", "honestly" or "straightforward".
4. Unique and semantically SEO optimised: primary and secondary keywords, related terms and real local detail. Never swap a suburb name into a template.
5. Generate schema markup (Service + FAQPage + BreadcrumbList, provider @id https://fridgerepairparramatta.com.au/#business; BlogPosting for blogs). Build it into the page and save it as a .json file. No aggregateRating without visible, verifiable reviews.
6. Attractive meta title (about 55 to 60 characters) and meta description (about 140 to 155) written for high CTR: primary keyword first, a real benefit or number, a clear promise. Count the characters.
7. Create and add internal linking: links inside the copy to hub, service, commercial, brand, area and blog pages. Link only to pages that are live. Say which existing pages should link back.
8. Mobile-first and fully responsive on mobile and desktop. Reuse the site's existing design (dark slate hero, white and slate-50 sections, cards, numbered steps, tables, FAQ accordion, dark CTA band).
9. Deliver: a Word content file (SEO set-up, competitor table, sections, checklist, sources), the schema .json, and a responsive HTML page of the same content. Update the project docs afterwards.
10. Reply briefly. For "today task" requests give 2 to 3 short bullets.
Always: use [placeholders] for the phone, ARCtick number and unconfirmed prices. Use the Sydney price table in section 6. Never invent keyword volume or KD (no Semrush connected). Never invent reviews, years or stats.

## 9. Top competitors (Parramatta SERP)
- Fridges R Us: strongest; 839+ reviews; brand pages
- Agility
- Parrahills (sydneyfridgerepair + parrahills)
- Fridge Repair Experts ($69 call-out)
- Fast Fridge
- Fridge Experts
- Ace
- Master Fridge
- AJ&T (Prospect)
- P&R Refrigeration (North Parramatta, commercial)

Their common gaps: no FAQs, few brand pages, no pricing, thin template suburb pages.
