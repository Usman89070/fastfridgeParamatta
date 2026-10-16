# Page progress

**Update this file after every page. At the start of each session: read this file, find the first TO DO page in the build order below, tell the user "Today's page: X (URL, primary keyword)" in 1 line, and build it.** The user must not have to say which page is next.

Standing rules: `claude/content-standard.md` and `claude/website-context.md`. Keyword data: `claude/keyword-strategy.md`. Flat URLs only. Never invent reviews, stats, phone or ARCtick numbers.

## Build order (new pages only, from the sheet's priority list)

1. COMM-FRIDGE: Commercial Fridge & Refrigeration Repair (hub) -> `/commercial-refrigeration-repair` (Wk 1-2 P1) [DONE 16 Oct]
2. COOLROOM: Coolroom & Cold Room Repair -> `/coolroom-repair` (Wk 1-2 P1) [DONE 16 Oct]
3. COMM-FREEZER: Commercial Freezer Repair -> `/commercial-freezer-repair` (Wk 3-4 P1) [TO DO]
4. ICE: Ice Machine Repair -> `/ice-machine-repair` (Wk 3-4 P2) [TO DO]
5. SEAL: Fridge Door Seal Replacement -> `/fridge-door-seal-replacement` (Wk 3-4 P1) [TO DO]
6. FREEZER: Freezer Repair -> `/freezer-repair` (Wk 1-2 P1) [TO DO]
7. BR-WESTINGHOUSE: Westinghouse Fridge Repair -> `/westinghouse-fridge-repair` (Wk 3-4 P1) [TO DO]
8. BR-FP: Fisher & Paykel Fridge Repair -> `/fisher-paykel-fridge-repair` (Wk 3-4 P1) [TO DO]
9. COMPRESSOR: Fridge Compressor Repair & Replacement -> `/fridge-compressor-repair` (Wk 3-4 P2) [TO DO]
10. BR-ELECTROLUX: Electrolux Fridge Repair -> `/electrolux-fridge-repair` (Wk 5-6 P2) [TO DO]
11. BR-HAIER: Haier Fridge Repair -> `/haier-fridge-repair` (Wk 5-6 P2) [TO DO]
12. BR-HISENSE: Hisense Fridge Repair -> `/hisense-fridge-repair` (Wk 5-6 P2) [TO DO]
13. AREAS: Areas We Service (hub) -> `/areas` (Wk 5-6 P2) [TO DO]
14. LOC-BLACKTOWN: Fridge Repair Blacktown -> `/fridge-repair-blacktown` (Wk 5-6 P2) [TO DO]
15. LOC-HILLS: Fridge Repair Hills District -> `/fridge-repair-hills-district` (Wk 5-6 P2) [TO DO]
16. B-LEAK: Blog: Why Is My Fridge Leaking Water? -> `/blog-why-is-my-fridge-leaking-water` (Wk 5-6 P2) [TO DO]
17. BAR-WINE: Bar, Wine & Mini Fridge Repair -> `/bar-wine-fridge-repair` (Wk 5-6 P3) [TO DO]
18. BR-MIELE: Miele Fridge Repair -> `/miele-fridge-repair` (Wk 7-8 P3) [TO DO]
19. B-FREEZER: Blog: Freezer Not Freezing -> `/blog-freezer-not-freezing` (Wk 7-8 P3) [TO DO]
20. B-NOISE: Blog: Fridge Making Noise -> `/blog-fridge-making-noise` (Wk 7-8 P3) [TO DO]
21. EXP-WSYD: Western Sydney (Penrith, Smithfield, St Marys...) -> `/fridge-repair-western-sydney` (Wk 7-8 P3) [TO DO]

## Already built (do not redo)

- REGAS: `/fridge-regas` [LIVE (built 14 Oct; optimise per sheet later)]
- BR-SAMSUNG: `/samsung-fridge-repair-parramatta` [DONE (live)]
- BR-LG: `/lg-fridge-repair` [DONE (live)]
- COMM-FRIDGE: `/commercial-refrigeration-repair` [DONE 16 Oct; schema in claude/schemas/]
- COOLROOM: `/coolroom-repair` [DONE 16 Oct; schema in claude/schemas/]

## Live pages that still need the sheet's title/meta/H1 optimisation (later phase)

- HOME: `/`
- SERV-HUB: `/services`
- NOTCOOL: `/fridge-not-cooling-repair`
- REGAS: `/fridge-regas`
- COST: `/fridge-repair-cost`
- EMERG: `/emergency-fridge-repair`
- BRANDS: `/brands`
- B-NOTCOOL: `/blog-fridge-not-cooling-causes`
- B-SUMMER: `/blog-summer-fridge-maintenance-tips`

## Log
- 14 Oct 2026: /fridge-regas built.
- 15 Oct 2026: /samsung-fridge-repair-parramatta and /lg-fridge-repair built from user-supplied HTML.
- 16 Oct 2026: keyword sheet saved to claude/. Built COMM-FRIDGE (/commercial-refrigeration-repair). Competitor sites could not be fetched (network block), used sheet benchmarks only. Linked from header/footer "Commercial Fridge Repair", services, cost, emergency pages. Spoke links (coolroom, freezer, ice) are plain text until those pages exist: when each spoke is built, link it from COMM-FRIDGE (equipment cards, FAQ 8) and the footer.
- 16 Oct 2026: Built COOLROOM (/coolroom-repair). Owner confirmed the page did not exist on the live site. Coolroom installation NOT claimed (unconfirmed). Linked from header/footer, services, cost, emergency, and the COMM-FRIDGE hub.
- RULE: before building any page, check the live site if the network allows (sandbox could not reach fridgerepairparramatta.com.au on 16 Oct); otherwise ask the owner to confirm the page does not already exist.
- Next: COMM-FREEZER (/commercial-freezer-repair).
