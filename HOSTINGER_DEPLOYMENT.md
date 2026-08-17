# 🚀 Hostinger Deployment Guide - Fridge Repair Parramatta

This project is fully prepared and optimized for 1-click deployment on **Hostinger Web Hosting** (Shared Hosting, Cloud Hosting, WordPress Hosting, or VPS).

---

## 📁 Files Included in Hostinger Package

All files are located in your workspace directory (`c:\Users\Usman Khan\Desktop\ffp\`):

| File / Folder | Purpose for Hostinger |
| :--- | :--- |
| `index.html` | Primary landing page containing all 25 content sections & SEO metadata |
| `styles.css` | Production CSS styles, glassmorphic effects & responsive layout |
| `app.js` | Interactive booking wizard, calculators, search filters & accordions |
| `.htaccess` | Apache configuration: Forces HTTPS, Gzip compression, browser caching & clean URL slug `/fridge-repair-parramatta/` |
| `sitemap.xml` | Search Engine sitemap for Google Search Console |
| `robots.txt` | Crawler indexing instructions pointing to `sitemap.xml` |
| `images/` | Product images directory |

---

## 🛠️ Step-by-Step Deployment Instructions

### Option 1: Upload via Hostinger hPanel File Manager (Recommended & Fastest)

1. Log into your [Hostinger hPanel](https://hpanel.hostinger.com/).
2. Navigate to **Websites** & click **Manage** next to your domain (`fridgerepairparramatta.com.au`).
3. Click **File Manager** (Files section) and open the **`public_html`** directory.
4. Click the **Show Hidden Files** toggle (gear icon top right) to ensure `.htaccess` is visible.
5. Select all files from `c:\Users\Usman Khan\Desktop\ffp\` (`index.html`, `styles.css`, `app.js`, `.htaccess`, `robots.txt`, `sitemap.xml`, and the `images/` directory).
6. Drag and drop them directly into the **`public_html`** folder on Hostinger.

---

### Option 2: Upload via FTP (FileZilla / WinSCP)

1. In Hostinger hPanel, go to **Files -> FTP Accounts** and copy your **FTP Host**, **FTP Username**, and **Password**.
2. Open FileZilla, connect to your Hostinger server.
3. Open `/public_html/` on the remote server side.
4. Upload all files from `c:\Users\Usman Khan\Desktop\ffp\` to `/public_html/`.

---

## 🔒 Post-Deployment Checklist on Hostinger

1. **Activate Free SSL (HTTPS)**:
   - Go to **Security -> SSL** in hPanel.
   - Click **Install SSL** (Hostinger provides free lifetime SSL via Let's Encrypt).
   - Our `.htaccess` file will automatically redirect all `http://` traffic to `https://`.

2. **Verify URL Slug `/fridge-repair-parramatta/`**:
   - Access `https://yourdomain.com/fridge-repair-parramatta/` in your browser.
   - The `.htaccess` rewrite rule ensures this URL loads seamlessly.

3. **Submit Sitemap to Google Search Console**:
   - Add your website property in Google Search Console.
   - Go to **Sitemaps** and submit `https://yourdomain.com/sitemap.xml`.
