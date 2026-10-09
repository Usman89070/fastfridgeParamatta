-- Fridge Repair Parramatta - Blog Admin Panel Database Schema
-- Import this file directly via Hostinger hPanel -> Databases -> phpMyAdmin -> Import
-- (or via the 'Import' tool on an existing empty database).

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blog_posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(150) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  meta_description VARCHAR(300) NOT NULL DEFAULT '',
  excerpt VARCHAR(500) NOT NULL DEFAULT '',
  content LONGTEXT NOT NULL,
  featured_image VARCHAR(255) NOT NULL DEFAULT '',
  read_time_minutes INT UNSIGNED NOT NULL DEFAULT 5,
  status ENUM('draft','published') NOT NULL DEFAULT 'draft',
  published_at DATE DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status_published (status, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin login: username 'admin', password 'FridgeAdmin2026!'
-- IMPORTANT: log in immediately after setup and change this password
-- from the admin panel (Change Password page).
INSERT INTO admin_users (username, password_hash) VALUES
  ('admin', '$2y$12$ymmgBGULbtflExAFkn5Qwuu2zQH5OAFCK4dswukf76q/nPleTuyoW');

-- Migrated existing blog posts
INSERT INTO blog_posts (slug, title, meta_description, excerpt, content, read_time_minutes, status, published_at) VALUES
  ('fridge-not-cooling-causes', 'Fridge Not Cooling? 7 Common Causes (And What To Do)', 'Fridge warm but the light still works? Here are the 7 most common reasons a fridge stops cooling, what each one means, and when to call a technician.', 'From a dirty condenser coil to a failed compressor, here''s how to recognise the seven most common reasons a fridge stops cooling.', '<p>A fridge that''s gone warm overnight is one of the most common calls we get - and one of the most stressful for whoever opens the door first. The good news is that "not cooling" almost never means the whole fridge is dead. It usually points to one specific, identifiable fault. Here are the seven causes we see most often, roughly in order of how frequently they turn up.</p>

<h2>1. A Dirty Condenser Coil</h2>
<p>The condenser coil - usually at the back or underneath the fridge - releases the heat pulled out of the compartment. When it''s caked in dust and pet hair, the compressor has to work harder and struggles to keep up, especially in a hot Western Sydney summer. Vacuuming the coil every six months is one of the cheapest, most effective things you can do to prevent a breakdown.</p>

<h2>2. A Failed Evaporator Fan</h2>
<p>This small fan circulates cold air from the evaporator coil through the fridge and freezer compartments. If it''s seized, obstructed by ice, or has a worn bearing, cold air stops moving even though the compressor is still running. You''ll often hear a buzzing or rattling noise, or notice the freezer is fine but the fridge section is warm.</p>

<h2>3. A Faulty Start Relay or Capacitor</h2>
<p>The compressor needs a jolt of extra power to start spinning. The start relay and capacitor provide that jolt. When either fails, the compressor tries to start, clicks, and gives up - often repeatedly, every few minutes. This is frequently mistaken for "the compressor is dead," but it''s usually a much cheaper part to replace.</p>

<h2>4. A Defrost System Fault</h2>
<p>Frost-free fridges periodically melt any ice building up on the evaporator coil using a small heater on a timer. If the defrost heater, timer, or sensor fails, ice builds up until it blocks airflow entirely. This is the classic cause of "freezer''s fine, fridge is warm" on modern frost-free models.</p>

<h2>5. A Perished Door Seal</h2>
<p>A torn or warped door gasket lets warm, humid air leak in continuously. The compressor runs almost non-stop trying to compensate, your power bill climbs, and you''ll often see condensation or ice forming around the door edge. Test it with a sheet of paper - if you can pull it out easily with the door shut, the seal needs replacing.</p>

<h2>6. Low Refrigerant From a Leak</h2>
<p>A sealed refrigeration system doesn''t use up gas over time - if it''s low, there''s a leak somewhere in the line. This usually shows up as a fridge that cools a little, then drifts warm again, or never quite reaches temperature. It needs proper leak detection, a repair, and a correctly weighed recharge, not just a "top-up."</p>

<h2>7. A Failed Compressor</h2>
<p>The least common cause on this list, but the most expensive. A genuinely failed compressor usually runs hot to the touch and hums loudly, or won''t start at all. Because it''s a sealed unit, it can''t be repaired internally - only replaced - which is why it''s worth having it properly tested rather than assumed, since points 3 and 6 above produce very similar symptoms for a fraction of the cost.</p>

<div class="callout">
<h3>When to Call a Technician</h3>
<p>If your fridge is warm but the light still works, don''t keep opening the door to check - that only lets more warm air in. A quick call gets you a proper diagnosis before you spend money guessing at parts. See our full <a href="/#common-faults">fault finder</a> for more symptoms, or book a technician directly below.</p>
</div>', 6, 'published', '2026-08-10'),
  ('repair-or-replace-guide', 'Repair or Replace Your Fridge? How to Tell If It''s Worth Fixing', 'Is it worth repairing a fridge or time to replace it? A Parramatta fridge technician explains the 50% rule, fridge lifespan and real repair costs.', 'Our 50% rule, the CHOICE value method, a fault-by-fault repair-or-replace table with Sydney prices, and a quick checklist to decide.', '<p><em>By [Technician Name], Licensed Refrigeration Mechanic (NSW Lic #R38910 [confirm]) · ARCtick [AU number]</em></p>

<p>"Is it worth repairing a fridge, or should I just buy a new one?" We get asked that on almost every job. The honest answer is that it depends on three things: how old the fridge is, what''s actually wrong with it, and what a comparable new one would cost you. Get those three straight and the decision usually makes itself.</p>

<p>This guide walks through the rules we use when we''re standing in someone''s kitchen in Parramatta with the back panel off, including the cases where we tell people not to spend money on a repair.</p>

<div class="callout">
<h3>Is It Worth Repairing a Fridge?</h3>
<p>Usually, yes, if the fridge is under about 8 years old and the repair costs less than half the price of a similar new fridge. Seals, fans, thermostats, relays and defrost parts are almost always worth fixing. A failed compressor or gas leak on a cheap fridge over 10 years old usually isn''t.</p>
</div>

<h2>How Long Do Fridges Last?</h2>
<p>Most fridges in Australian homes last somewhere between 10 and 15 years. CHOICE puts the average at around 10 years, with a range of roughly 6 to 20 depending on build quality. In our experience, how a fridge is looked after and where it lives matter almost as much as the brand.</p>
<p>A fridge squeezed into a tight cabinet, or sitting in a hot Parramatta garage or laundry, works much harder than one with room to breathe in an air-conditioned kitchen. Heat is the biggest thing that shortens fridge lifespan in Australia, and Western Sydney summers don''t help.</p>

<p><strong>Typical fridge lifespan in Australia (a guide, not a guarantee):</strong></p>
<ul>
<li><strong>Top-mount / bottom-mount:</strong> 10–15 years. Simple design, parts easy to get. Usually the longest-lived.</li>
<li><strong>Side-by-side / French door:</strong> 10–14 years. More electronics, ice makers and fans to go wrong, but worth repairing because they''re dear to replace.</li>
<li><strong>Integrated / built-in (premium):</strong> 12–20 years. Built to last and expensive to replace, so repair almost always wins.</li>
<li><strong>Bar fridges / budget models:</strong> 6–10 years. Cheap to replace, so big repairs rarely make sense.</li>
<li><strong>Chest freezers:</strong> 12–20 years. Very simple, often outlast the main fridge.</li>
</ul>
<p>Not sure how old your fridge is? The model sticker inside the fridge, or on the back, usually shows the manufacture date or a serial number that includes it.</p>

<h2>Repair or Replace Your Fridge: 3 Simple Rules</h2>

<h3>Rule 1: The 50% rule</h3>
<p>If the repair costs more than half the price of a comparable new fridge, replacing is usually better value. A $350 repair on a fridge that would cost $1,800 to replace is an easy yes. A $900 repair on a fridge you could replace for $1,100 is a hard no.</p>

<h3>Rule 2: The age rule</h3>
<p>Under about 8 years old, repair almost anything except a major sealed-system failure on a budget fridge. Between 8 and 12 years, repair the cheap and mid-range faults, and think hard about the expensive ones. Over 12 years, only spend serious money if it''s a quality fridge in otherwise good condition.</p>

<h3>Rule 3: What''s the fridge actually worth?</h3>
<p>CHOICE suggests a simple way to put a number on it: divide what you paid by 10, then multiply by the years it has left. A $2,000 fridge that''s 4 years old is worth about $200 a year, with around 6 years to go, so roughly $1,200 of value left. A $400 repair on that fridge is good money spent.</p>
<p>Try our <a href="/#repair-vs-replace" rel="noopener">repair vs replace value checker</a>.</p>

<h2>Fridge Repair vs Replace: What We Recommend by Fault</h2>
<p>The fault matters more than anything else. Here''s how we usually call it, based on typical Sydney repair prices including parts and labour.</p>
<ul>
<li><strong>Door seal</strong> — $120–$300. Under 8 years: repair. Over 10 years: repair.</li>
<li><strong>Thermostat / temperature sensor</strong> — $150–$300. Under 8 years: repair. Over 10 years: repair.</li>
<li><strong>Start relay / capacitor</strong> — $120–$250. Under 8 years: repair. Over 10 years: repair.</li>
<li><strong>Fan motor</strong> — $180–$400. Under 8 years: repair. Over 10 years: usually repair.</li>
<li><strong>Defrost heater, timer or sensor</strong> — $150–$350. Under 8 years: repair. Over 10 years: usually repair.</li>
<li><strong>Blocked drain / water leak</strong> — $120–$300. Under 8 years: repair. Over 10 years: repair.</li>
<li><strong>Ice maker / water valve</strong> — $150–$400. Under 8 years: repair. Over 10 years: depends on the fridge''s value.</li>
<li><strong>Control board</strong> — $250–$600. Under 8 years: repair. Over 10 years: depends, check part availability.</li>
<li><strong>Gas leak + regas</strong> — $250–$600. Under 8 years: usually repair. Over 10 years: often replace (budget fridge).</li>
<li><strong>Compressor replacement</strong> — $450–$1,100. Under 8 years: repair if mid-range or premium. Over 10 years: usually replace.</li>
</ul>
<p><em>Typical Sydney prices, call-out fee extra.</em> See the full <a href="fridge-repair-cost" rel="noopener">fridge repair cost guide</a>.</p>
<p>One thing to watch: a fridge that won''t start is often blamed on the compressor when the real culprit is a $150 start relay. Always ask for proper testing before you write the fridge off.</p>

<h2>When Repairing Is Almost Always Worth It</h2>
<ul>
<li>The fridge is under 8 years old and has a single fault.</li>
<li>The fault is a common, inexpensive part: a <a href="services#by-fault" rel="noopener">seal, fan, thermostat, relay or defrost component</a>.</li>
<li>It''s a premium, French-door or integrated model. Replacing it means spending thousands, and sometimes new cabinetry too.</li>
<li>The fridge fits your kitchen perfectly. Odd-sized cavities are surprisingly hard to fill.</li>
<li>You''d rather not send a working appliance to landfill over a $200 part.</li>
</ul>

<h2>When Replacing an Old Fridge Makes More Sense</h2>
<p>Is it worth repairing an old fridge? Sometimes not. We''ll tell you straight if we think you''re better off replacing it, which usually comes down to one of these:</p>
<ul>
<li>A budget fridge over 10 years old with a failed <a href="services#by-fault" rel="noopener">compressor</a> or a <a href="services#regas-service" rel="noopener">sealed-system gas leak</a>.</li>
<li>Several faults at once, or the same fault coming back after repairs.</li>
<li>Rust through the cabinet, a cracked inner liner, or insulation that''s breaking down (sweating outside walls).</li>
<li>Parts are no longer available for the model, which happens with some older imported and online-only <a href="brands" rel="noopener">brands</a>.</li>
<li>The repair would cost more than half the price of a comparable new fridge.</li>
</ul>

<h2>The Hidden Costs of a New Fridge</h2>
<p>The price tag isn''t the whole story. When you compare a repair quote against replacing, add these in:</p>
<ul>
<li>Delivery and installation, and connecting a plumbed ice maker or water line if your new fridge has one.</li>
<li>Removing the old fridge. Old fridges contain refrigerant that must be recovered properly, so you can''t just leave it on the kerb. Check your council''s clean-up service or ask the retailer about removal.</li>
<li>Size headaches. New models are often deeper or taller. If it doesn''t fit the cavity, you may be paying a carpenter as well.</li>
<li>Waiting for stock, plus any food you lose in the meantime.</li>
</ul>

<h2>Will a New Fridge Save Money on Power?</h2>
<p>Newer fridges are generally more efficient, but the savings are often smaller than people expect. Here''s a rough example: an older fridge using 600 kWh a year versus a new one using 400 kWh saves about 200 kWh. At around 35c per kWh, that''s roughly $70 a year. It''s handy, but on its own it rarely justifies replacing a fridge that only needs a $250 repair.</p>
<p>Check the Energy Rating label when you do buy. It shows the estimated kWh per year, so you can compare models properly. And if your power bill has jumped for no obvious reason, it can be a sign the fridge is struggling. That''s worth a check either way.</p>

<h2>Before You Pay for a Repair: Check Warranty and Recalls</h2>
<ol>
<li>Manufacturer warranty. Many new fridges come with around 2 years'' cover, and some brands offer longer on the compressor. Check your paperwork first.</li>
<li>Australian Consumer Law. A fridge should last a reasonable time for what you paid. If a fairly new fridge fails early, you may be entitled to a free repair, replacement or refund from the retailer, even after the warranty has ended.</li>
<li>Product recalls. Search your model on the ACCC''s Product Safety Australia website. A recalled fridge may be repaired or replaced free, whatever its age.</li>
</ol>
<p>If none of those apply, that''s where an independent repairer like us comes in.</p>

<h2>How We Help You Decide</h2>
<p>When we come out to a fridge in Parramatta or nearby, we test it properly first: electrical checks, temperatures, airflow and, if needed, the gas pressures. Then we tell you what''s wrong, what it''ll cost to fix, and whether we''d fix it if it were our fridge. You get a fixed quote before we start, and nothing goes ahead unless you agree. If the honest answer is to replace it, we''ll say so and you only pay for the visit.</p>
<p>Every repair we do is covered by a 1-year parts and labour warranty, which makes repairing a good fridge a much safer bet.</p>

<div class="callout">
<h3>Repair or Replace Fridge Checklist</h3>
<ul>
<li>How old is it? Under 8 years leans towards repair; over 12 leans towards replace.</li>
<li>What''s the fault? Cheap parts mean repair; a compressor on a budget fridge means replace.</li>
<li>Does the repair cost less than half a comparable new fridge?</li>
<li>Is it still under warranty, protected by consumer law, or recalled?</li>
<li>Is it a premium or built-in model that would be expensive to replace?</li>
<li>Are there several problems, rust or a cracked liner?</li>
</ul>
</div>

<h2>Repair or Replace FAQs</h2>

<h3>1. Is it worth repairing a 10-year-old fridge?</h3>
<p>It depends on the fault. A 10-year-old fridge with a failed seal, fan or thermostat is usually worth fixing. If it needs a new compressor or a gas leak repair costing more than half the price of a new fridge, replacing it is usually better value.</p>

<h3>2. How long do fridges last in Australia?</h3>
<p>Most last 10 to 15 years. CHOICE puts the average at about 10 years, with a range of roughly 6 to 20. Premium and built-in fridges tend to last longer, budget and bar fridges shorter.</p>

<h3>3. Is it worth repairing an old fridge with a compressor problem?</h3>
<p>On a budget fridge over 10 years old, usually not, because a compressor replacement often costs $450 to $1,100. On a quality fridge in good condition it can still make sense. Make sure it''s properly tested first, because a cheaper start relay fault can look the same.</p>

<h3>4. What is the 50% rule for fridges?</h3>
<p>If a repair costs more than half the price of a comparable new fridge, replacing it is usually the better choice. Below that, repair is generally worth it, especially on fridges under 8 years old.</p>

<h3>5. Is it cheaper to repair or replace a fridge?</h3>
<p>For most common faults, repairing is cheaper. Typical repairs in Sydney cost $150 to $450, while a new fridge costs anywhere from a few hundred dollars to several thousand, plus delivery, installation and removal of the old one.</p>

<h3>6. Does a new fridge use much less power?</h3>
<p>Newer fridges are usually more efficient, but the saving is often around $50 to $100 a year. That''s helpful, but not usually enough on its own to justify replacing a fridge that only needs a small repair.</p>

<h3>7. Will you tell me if my fridge isn''t worth fixing?</h3>
<p>Yes. After diagnosis we''ll tell you plainly whether we''d repair it or replace it. If it''s not worth fixing, you only pay for the visit.</p>

<h2>Not Sure? Get an Honest Answer</h2>
<p>If you''re still unsure whether it''s worth repairing your fridge, let us have a look. A licensed Parramatta technician will find the fault, give you a fixed price and tell you honestly which way we''d go. Same-day appointments are available where we can fit you in.</p>

<div class="callout">
<h3>Get a Fixed Price and an Honest Answer</h3>
<p>See the full <a href="fridge-repair-cost" rel="noopener">fridge repair cost guide</a>, or get in touch directly.</p>
<p><a href="mailto:info@fridgerepairparramatta.com.au" rel="noopener">Email us</a> or <a href="contact#contact-form" rel="noopener">book a repair online</a>.</p>
</div>

<div class="callout">
<h3>About the Author</h3>
<p><strong>[Technician Name]</strong>, Licensed Refrigeration Mechanic · NSW Lic #R38910 [confirm] · ARCtick [AU number] · [X] years repairing fridges across Western Sydney.</p>
<p><em>"[One line in their own words, e.g. ''I''d rather tell someone not to spend $800 on a tired fridge than have them call me back in six months.'']"</em></p>
</div>', 9, 'published', '2026-08-12'),
  ('summer-fridge-maintenance-tips', 'Summer Fridge Maintenance: 12 Fridge Maintenance Tips to Beat the Heat', 'Simple fridge maintenance tips from a Parramatta technician: how to clean condenser coils, cut power bills and stop your fridge failing in a heatwave.', 'A 12-point summer checklist, step-by-step coil cleaning, energy-saving tips and heatwave food-safety advice from a Parramatta refrigeration technician.', '<p><em>By [Technician Name], Licensed Refrigeration Mechanic (NSW Lic #R38910 [confirm]) · ARCtick [AU number]</em></p>

<p>Every summer our phones light up on the first run of 40°C days. Fridges that have been ticking along fine all year suddenly can''t keep up, and a lot of them fail on the hottest afternoon of the week, usually with a full load of shopping inside.</p>

<p>Here''s the thing: most of those breakdowns are avoidable. A fridge has to push heat out into the room, and when the room is already hot, the compressor works harder and runs longer. Give it a bit of help before summer and you''ll keep your food safe, your power bill down and your fridge going for years longer. These are the fridge maintenance tips we give our own customers across Parramatta and Western Sydney.</p>

<div class="callout">
<h3>The Most Important Fridge Maintenance Tips for Summer</h3>
<p>Clean the condenser coils, leave space around the fridge for air to flow, check the door seals, set the fridge to 3–4°C and the freezer to around -18°C, don''t overpack it, and keep it out of direct sun. These six steps take under an hour and prevent most summer breakdowns.</p>
</div>

<h2>12 Fridge Maintenance Tips to Get Through Summer</h2>

<h3>1. Clean the condenser coils</h3>
<p>This is the big one. The coils at the back or underneath your fridge release the heat taken out of your food. When they''re coated in dust and pet hair, that heat has nowhere to go, the compressor runs flat out, and on a hot day it can overheat and cut out. We''ve put the full step-by-step guide further down.</p>

<h3>2. Give it room to breathe</h3>
<p>Fridges need air moving around them. Check your manual for the exact clearance, but as a rule, leave a few centimetres at the sides and back and some space on top. A fridge jammed into a tight cabinet, or with bags and boxes stacked on it, runs hotter and works harder. If it''s built in, make sure the vents in the cabinetry aren''t blocked.</p>

<h3>3. Check the door seals</h3>
<p>Close the door on a sheet of paper. If it slides out with no resistance, warm air is getting in. Wipe the seals with warm soapy water (crumbs and sticky spills stop them sealing) and dry them well. Avoid harsh cleaners, which can crack the rubber. If a seal is torn or flattened, <a href="services#by-fault" rel="noopener">get it replaced</a> before summer.</p>

<h3>4. Set the right temperatures</h3>
<p>Aim for 3–4°C in the fridge and around -18°C in the freezer. Food Standards Australia New Zealand recommends keeping chilled food at 5°C or below. A cheap fridge thermometer in a glass of water on the middle shelf will tell you what''s really happening. Don''t crank the dial to the coldest setting on hot days. It doesn''t cool faster, it just makes the fridge run longer.</p>

<h3>5. Don''t overpack it</h3>
<p>A reasonably full fridge holds its temperature better than an empty one, but pack it so tight that air can''t move and parts of it will warm up. Keep the vents at the back of the fridge and freezer clear.</p>

<h3>6. Cool leftovers before they go in</h3>
<p>Putting a big pot of steaming food straight into the fridge makes everything around it warm up. Let it stop steaming, then refrigerate it within two hours. Splitting it into shallow containers helps it cool faster.</p>

<h3>7. Keep the door shut</h3>
<p>In summer, with kids home and drinks going in and out all day, the door gets opened constantly. Every time, cold air falls out and warm, humid air comes in. Think about what you need before you open it, and keep the drinks you reach for most at the front.</p>

<h3>8. Be careful with garage and outdoor fridges</h3>
<p>A lot of Parramatta homes have a second fridge in the garage, laundry or on the back patio, and those are the ones we see fail first. Garages can get well over 40°C in summer. Check the climate class on your fridge''s rating plate: a ''T'' (tropical) rating is designed to cope with room temperatures up to 43°C, while ''N'' (normal) is only designed for up to 32°C. If yours isn''t rated for the heat, move it somewhere cooler or give it as much shade and airflow as you can.</p>

<h3>9. Defrost manual freezers</h3>
<p>If you''ve got a chest freezer or an older freezer that builds up ice, defrost it before the ice gets about 5 mm thick. Thick ice acts like insulation and makes the freezer work much harder.</p>

<h3>10. Clear the defrost drain and drip tray</h3>
<p>Frost-free fridges melt their frost and drain the water to a tray underneath. If the drain hole at the back of the fridge is blocked, you''ll get water pooling under the crisper or ice on the back wall. A little warm water and a pipe cleaner usually clears it.</p>

<h3>11. Change the water filter</h3>
<p>If your fridge has a water and ice dispenser, change the filter as often as the manufacturer recommends, usually every six months. A clogged filter slows the water flow and can cause ice maker problems.</p>

<h3>12. Book a check before the first heatwave</h3>
<p>If your fridge is over five years old, noisy, or already running constantly, <a href="services#by-fault" rel="noopener">a quick service</a> in spring is cheaper than an emergency call-out in January. We clean the coils properly, test the seals, fans and temperatures, and pick up small problems before they turn into big ones.</p>

<h2>How to Clean Fridge Condenser Coils</h2>
<p>Cleaning the coils is the single most useful bit of fridge maintenance you can do yourself. It takes about 20 minutes and needs no special tools.</p>

<h3>What you''ll need</h3>
<ul>
<li>A vacuum with a brush or crevice attachment</li>
<li>A long, soft coil brush (about $10–$20 from a hardware store) or an old paintbrush</li>
<li>A torch, an old towel, and a helper if the fridge is heavy</li>
</ul>

<h3>Step by step</h3>
<ol>
<li>Switch off and unplug the fridge. Never clean coils with the power on. The condenser fan can start without warning.</li>
<li>Find the coils. On older fridges they''re the black grid on the back. On most newer fridges they''re underneath, behind the kick plate at the bottom front, often next to a small fan. Some fridges hide the condenser inside the side walls. If yours does, there''s nothing to clean, so just keep the vents and the area around the fridge clear.</li>
<li>Pull the fridge out gently. Put a towel down on tiles or timber to protect the floor, and don''t pull it so far that you stretch the power cord or water line.</li>
<li>Vacuum the loose dust off the coils, the fan and the floor underneath.</li>
<li>Brush out the packed dust. Slide the coil brush between the coils and fins, then vacuum again. Go gently; the fins bend easily.</li>
<li>Push it back and plug it in. Leave the recommended gap at the back, then give it a few hours to settle before checking the temperature.</li>
</ol>

<h3>How often should you clean fridge coils?</h3>
<p>Twice a year is about right for most homes, ideally in spring before summer and again in autumn. If you have pets, or the fridge lives in a dusty garage, do it every three months.</p>
<p>Don''t use water or spray cleaners on the coils, and don''t poke around the compressor or pipework. If you see oily marks on the pipes or hear hissing, that can mean a gas leak, which needs a licensed technician.</p>

<h2>Energy Efficient Fridge Tips to Cut Your Summer Power Bill</h2>
<p>Your fridge runs 24 hours a day, so small changes add up, especially in summer when it''s working hardest. These energy efficient fridge tips cost nothing or next to nothing:</p>
<ul>
<li>Keep it away from heat. Don''t put the fridge next to the oven, the dishwasher, or a window that gets afternoon sun.</li>
<li>Clean the coils and check the seals (above). These two do more for running costs than anything else.</li>
<li>Don''t over-cool it. Each degree colder than you need means the fridge runs longer. 3–4°C is plenty.</li>
<li>Rethink the second fridge. The Australian Government''s Energy Rating program points out that many households run a second fridge they don''t really need. If the beer fridge in the garage is half empty most of the year, consider switching it off outside summer. Empty it, clean it and leave the door ajar so it doesn''t go mouldy.</li>
<li>Cover food and liquids. Uncovered food releases moisture, which the fridge then has to deal with as frost.</li>
<li>When it''s time to replace, check the Energy Rating label. More stars means less power, and the label shows the estimated kWh per year so you can compare models properly.</li>
</ul>
<p>Thinking about replacing an old fridge? Read: <a href="blog-repair-or-replace-guide" rel="noopener">Repair or Replace Your Fridge?</a></p>

<h2>Heatwaves and Blackouts: Keeping Food Safe</h2>
<p>Summer storms and heatwaves bring power cuts. If the power goes out, keep the doors shut. A closed fridge will usually keep food cold for about four hours, and a full freezer for around 48 hours (about 24 if it''s half full).</p>
<p>Once the power is back, check the temperature. Food that has been above 5°C for less than two hours can go back in the fridge. Between two and four hours, use it straight away. Over four hours, throw it out. If the fridge won''t cool properly after the power returns, a surge may have damaged a part, so give us a call.</p>

<h2>A Note for Cafés and Restaurants</h2>
<p>Commercial fridges in hot kitchens have an even tougher summer. Clean the condensers more often (monthly in a busy kitchen with grease in the air), keep a daily temperature log so you notice a slow drift early, and book a service before December. A breakdown mid-service in January costs far more than the maintenance.</p>
<p><a href="services#commercial" rel="noopener">Commercial fridge servicing</a> is available for busy kitchens.</p>

<h2>Signs Your Fridge Is Struggling With the Heat</h2>
<ul>
<li>The compressor runs all the time and never seems to switch off.</li>
<li>The sides or front of the cabinet are much hotter than usual. Warm sides are normal on many fridges, but too-hot-to-touch isn''t.</li>
<li>Food is going off faster, or the thermometer reads above 5°C.</li>
<li>Water pooling inside or under the fridge, or ice building up on the back wall.</li>
<li>Clicking, buzzing or rattling that wasn''t there before.</li>
<li>Your power bill has jumped and nothing else has changed.</li>
</ul>
<p>If you notice any of these, book a check sooner rather than later. Small faults like a tired fan or a worn seal are cheap to fix now, but they can take out a compressor if they''re left through a hot summer.</p>
<p>Read more: <a href="blog-fridge-not-cooling-causes" rel="noopener">fridge not cooling guide</a> · <a href="fridge-repair-cost" rel="noopener">repair prices</a> · <a href="emergency-fridge-repair" rel="noopener">urgent help</a></p>

<h2>Fridge Maintenance Checklist: When to Do What</h2>
<ul>
<li><strong>Wipe spills and check use-by dates</strong> — Weekly, 5 min, DIY</li>
<li><strong>Check fridge and freezer temperatures</strong> — Monthly (weekly in summer), 2 min, DIY</li>
<li><strong>Clean the door seals</strong> — Every 3 months, 10 min, DIY</li>
<li><strong>Paper test on the seals</strong> — Every 6 months, 5 min, DIY</li>
<li><strong>Clean the condenser coils</strong> — Every 6 months (3 months with pets), 20 min, DIY</li>
<li><strong>Clear the defrost drain</strong> — Every 6 months, 10 min, DIY</li>
<li><strong>Change the water filter</strong> — Every 6 months, or as per the manual, 10 min, DIY</li>
<li><strong>Defrost a manual freezer</strong> — When ice reaches ~5 mm, 1–2 hrs, DIY</li>
<li><strong>Professional service (fans, gas, electrics)</strong> — Every 1–2 years, or before summer on older fridges, 45–60 min, Technician</li>
</ul>

<h2>Summer Fridge Maintenance FAQs</h2>

<h3>1. How do I keep my fridge cool in summer?</h3>
<p>Clean the condenser coils, leave space around the fridge for air to circulate, keep it out of direct sun and away from the oven, check the door seals, and avoid opening the door more than you need to. Set it to 3–4°C rather than the coldest setting.</p>

<h3>2. How often should I clean my fridge coils?</h3>
<p>About twice a year for most homes, ideally before summer and again in autumn. If you have pets or the fridge is in a dusty garage, clean them every three months.</p>

<h3>3. What temperature should my fridge be in summer?</h3>
<p>The same as the rest of the year: 3–4°C in the fridge and around -18°C in the freezer. Food Standards Australia New Zealand recommends keeping chilled food at 5°C or below.</p>

<h3>4. Is it OK to keep a fridge in the garage in summer?</h3>
<p>Only if it''s rated for the heat. Check the climate class on the rating plate. A ''T'' (tropical) rated fridge is designed for room temperatures up to 43°C, while an ''N'' rated one is only designed for up to 32°C. Give it plenty of airflow and keep it out of the sun.</p>

<h3>5. Why does my fridge run constantly in hot weather?</h3>
<p>Some extra running is normal on very hot days. If it never switches off, the usual causes are dirty condenser coils, poor ventilation, a leaking door seal or low refrigerant. Clean the coils and check the seals first, and book a technician if it doesn''t improve.</p>

<h3>6. Does cleaning the coils really save power?</h3>
<p>Yes. Clean coils let the fridge get rid of heat more easily, so the compressor doesn''t run as long. It also takes strain off the compressor, which is the most expensive part to replace.</p>

<h2>Get Your Fridge Ready Before the Heat Hits</h2>
<p>A bit of maintenance now goes a long way in a Western Sydney summer. Work through these fridge maintenance tips, and if your fridge is older, noisy or already struggling, let us give it a once-over before the first heatwave. A licensed Parramatta technician will clean it properly, test it and tell you honestly how it''s going.</p>

<div class="callout">
<h3>Fridge Maintenance Services in Parramatta</h3>
<p>Our licensed technicians service homes across Parramatta and nearby suburbs, including Westmead, Harris Park, North Parramatta, Granville, Merrylands, Wentworthville and Northmead. We can clean your condenser coils, test your seals and thermostat, and tell you honestly whether your fridge will last another summer.</p>
<p><a href="mailto:info@fridgerepairparramatta.com.au" rel="noopener">Email us</a> or <a href="contact#contact-form" rel="noopener">book a fridge service online</a>.</p>
</div>

<div class="callout">
<h3>About the Author</h3>
<p><strong>[Technician Name]</strong>, Licensed Refrigeration Mechanic · NSW Lic #R38910 [confirm] · ARCtick [AU number] · [X] years repairing fridges across Western Sydney.</p>
<p><em>"[One line in their own words, e.g. ''Most January call-outs I go to, the coils haven''t been cleaned in years.'']"</em></p>
</div>', 10, 'published', '2026-08-14');
