-- SEO management panel: pages + redirects tables.
-- Import this via Hostinger hPanel -> Databases -> phpMyAdmin -> SQL tab,
-- on the SAME database that already has blog_posts/admin_users.
-- Safe to re-run: uses IF NOT EXISTS / INSERT IGNORE throughout.

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS pages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(150) NOT NULL UNIQUE,
  label VARCHAR(150) NOT NULL DEFAULT '',
  title VARCHAR(255) NOT NULL DEFAULT '',
  meta_description VARCHAR(300) NOT NULL DEFAULT '',
  canonical_url VARCHAR(255) NOT NULL DEFAULT '',
  h1 VARCHAR(255) NOT NULL DEFAULT '',
  og_title VARCHAR(255) NOT NULL DEFAULT '',
  og_description VARCHAR(300) NOT NULL DEFAULT '',
  primary_keyword VARCHAR(150) NOT NULL DEFAULT '',
  secondary_keywords VARCHAR(500) NOT NULL DEFAULT '',
  robots_meta VARCHAR(100) NOT NULL DEFAULT 'index,follow',
  schema_json LONGTEXT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS redirects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  from_path VARCHAR(255) NOT NULL UNIQUE,
  to_path VARCHAR(255) NOT NULL,
  status_code SMALLINT UNSIGNED NOT NULL DEFAULT 301,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS site_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  image_key VARCHAR(150) NOT NULL UNIQUE,
  src VARCHAR(255) NOT NULL DEFAULT '',
  alt_text VARCHAR(255) NOT NULL DEFAULT '',
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed row for the 'about' page, matching its current live values exactly -
-- importing this changes nothing visible until you edit it from the admin
-- panel. More pages are added here as each one is converted.
INSERT IGNORE INTO pages
  (slug, label, title, meta_description, canonical_url, h1, og_title, og_description, robots_meta, schema_json)
VALUES
  (
    'about',
    'About Us',
    'About Us | Fridge Repair Parramatta',
    'Licensed refrigeration mechanics with 30+ years of experience servicing Parramatta and Western Sydney. Learn how we work and why local customers trust us.',
    'https://fridgerepairparramatta.com.au/about',
    'About Fridge Repair Parramatta',
    'About Us | Fridge Repair Parramatta',
    'Licensed refrigeration mechanics with 30+ years of experience servicing Parramatta and Western Sydney. Learn how we work and why local customers trust us.',
    'index,follow',
    '{"@context":"https://schema.org","@type":"HVACBusiness","name":"Fridge Repair Parramatta","image":"images/hero_refrigeration_tech.jpg","url":"https://fridgerepairparramatta.com.au/about","email":"info@fridgerepairparramatta.com.au","priceRange":"$$","description":"Licensed residential and commercial refrigeration mechanics servicing Parramatta and Western Sydney, with 30+ years of experience and a 1-year workmanship warranty.","address":{"@type":"PostalAddress","streetAddress":"Church Street","addressLocality":"Parramatta","addressRegion":"NSW","postalCode":"2150","addressCountry":"AU"},"geo":{"@type":"GeoCoordinates","latitude":-33.815,"longitude":151.0011}}'
  );
