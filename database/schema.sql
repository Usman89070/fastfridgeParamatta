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
  ('repair-or-replace-guide', 'Repair or Replace? A Practical Guide for Sydney Homeowners', 'Not sure whether to repair your fridge or buy a new one? Here''s the rule of thumb we actually use, with real examples for common Parramatta situations.', 'The rule of thumb we actually use when deciding whether a fridge is worth fixing, with real cost examples.', '<p>This is the question we get asked more than almost any other: "is it even worth fixing?" It''s a fair question - nobody wants to spend $300 on a repair only to have the fridge fail again in six months. There''s no single answer that fits every fridge, but there is a rule of thumb that gets it right most of the time.</p>

<h2>The Rule of Thumb</h2>
<p>Weigh the repair cost against the replacement cost, and factor in age. As a general guide: if the repair costs less than roughly 30-50% of the price of a comparable new unit, and the fridge is under about 8 years old, repairing is usually the better financial decision. Outside that range, it starts tipping toward replacement - but age and cost aren''t the whole story, which is why we look at the actual fault too.</p>

<h2>When Repair Almost Always Wins</h2>
<ul>
<li><strong>A fridge under 8 years old with a common part fault</strong> - a fan motor, thermostat, door seal, or start relay. These are inexpensive parts, and the rest of the unit typically has plenty of life left.</li>
<li><strong>A premium French door, integrated or built-in unit</strong> - replacement cost is high enough that even a moderately expensive repair is usually still the cheaper path, and integrated units in particular can be a hassle to replace like-for-like.</li>
<li><strong>Anything still under manufacturer warranty</strong> - always check with the manufacturer before paying for an independent repair, so you don''t accidentally void remaining cover.</li>
</ul>

<h2>When Replacement Usually Makes More Sense</h2>
<ul>
<li><strong>An older budget fridge (10+ years) with a failed compressor or sealed-system leak</strong> - these are the two most expensive repairs, and on an entry-level unit the cost can approach that of a new fridge.</li>
<li><strong>A unit with repeated, recurring faults</strong> - if you''ve already paid for two or three separate repairs in the last year or two, the fridge is telling you something. At that point we''ll usually recommend replacing rather than continuing to patch it.</li>
</ul>

<h2>A Real Example</h2>
<p>A 6-year-old mid-range fridge in Westmead with a $280 fan motor repair, against a $1,400 replacement cost, is a clear repair - the cost is 20% of replacement and the unit is young. Compare that to a 12-year-old bar fridge with a failed compressor: a $450 repair against a $500 replacement unit isn''t worth it, even though the dollar figures look similar on paper.</p>

<div class="callout">
<h3>Try Our Interactive Calculator</h3>
<p>Enter your fridge''s age, original price and estimated repair cost into our <a href="/#repair-vs-replace">repair vs replace value checker</a> for an instant recommendation, or book a technician for a proper diagnosis and we''ll give you a straight answer either way.</p>
</div>', 5, 'published', '2026-08-12'),
  ('summer-fridge-maintenance-tips', '5 Ways to Keep Your Fridge Running Through a Parramatta Summer', 'Western Sydney summers are hard on fridges and freezers. Five practical maintenance habits that meaningfully cut your risk of a breakdown when it''s 40°C outside.', 'Simple habits that meaningfully cut your risk of a breakdown when it''s 40°C outside in Western Sydney.', '<p>When the mercury pushes past 40°C in Western Sydney - routinely several degrees hotter than the coastal suburbs - fridges and freezers work overtime just to hold a safe temperature. A big share of the breakdowns we attend across Parramatta cluster in the January and February heatwaves. The good news is that most of the units that fail were already running compromised for months beforehand. Here''s what actually helps.</p>

<h2>1. Vacuum the Condenser Coils</h2>
<p>This is the single highest-impact thing you can do, and it takes ten minutes. Dust and pet hair insulate the coil, forcing the compressor to run longer and hotter to shed the same amount of heat. Do it every six months, more often if you have pets or the fridge sits in a dusty garage.</p>

<h2>2. Give It Room to Breathe</h2>
<p>Keep at least 5cm of clearance behind and above the fridge for airflow. A unit pushed hard against a wall in a stuffy garage or an unshaded laundry is one of the first to give up in a heatwave, because it has nowhere to release the heat it''s pulling out of the cabinet.</p>

<h2>3. Check the Door Seals</h2>
<p>Close the door on a sheet of paper and try to pull it out. If it slides out easily, warm air is leaking in continuously, and the compressor has to run almost non-stop to compensate - exactly what you don''t want in summer. Perished seals are a cheap fix with an outsized payoff on your power bill and your fridge''s workload.</p>

<h2>4. Don''t Overpack It</h2>
<p>Cold air needs room to circulate to cool everything evenly. An overstuffed fridge - common over the Christmas and New Year period - blocks airflow around the shelves, leaving some items warmer than they should be even though the thermostat reads normal.</p>

<h2>5. Book a Check-Up Before Summer, Not During It</h2>
<p>If your fridge has been making a new noise, running longer than it used to, or struggling to hold temperature through the cooler months, it''s already telling you something. Getting it looked at in spring means a small, cheap fix instead of an emergency call-out (and a bin full of spoiled food) in the middle of a 40°C week.</p>

<div class="callout">
<h3>Running a Commercial Kitchen or Coolroom?</h3>
<p>The same principles apply at commercial scale, with more at stake. If you run multiple units, a scheduled maintenance arrangement is dramatically cheaper than an emergency breakdown mid-service on a Saturday night. See our <a href="/#services">commercial refrigeration services</a> for details.</p>
</div>', 4, 'published', '2026-08-14');

