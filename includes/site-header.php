<?php
/**
 * Shared public-facing header for the dynamic blog pages (blog.php,
 * blog-post.php). Mirrors the header markup duplicated across every static
 * .html page so the dynamic pages look identical to the rest of the site.
 *
 * Expects these variables to be set before including this file:
 *   $pageTitle          string  <title> text
 *   $metaDescription    string  meta description / og:description
 *   $canonicalUrl       string  full canonical URL
 *   $ogType             string  'website' or 'article' (optional, defaults to 'website')
 */

$ogType = $ogType ?? 'website';
?><!DOCTYPE html>
<html lang="en-AU" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://cdn.tailwindcss.com">
  <link rel="preconnect" href="https://unpkg.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- SEO META -->
  <title><?= e($pageTitle) ?></title>
  <link rel="icon" type="image/webp" href="image/FFp-logo.webp">
  <link rel="apple-touch-icon" href="image/FFp-logo.webp">
  <meta name="description" content="<?= e($metaDescription) ?>">
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">

  <!-- Open Graph / Social Meta -->
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($metaDescription) ?>">
  <meta property="og:type" content="<?= e($ogType) ?>">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            trade: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              500: '#0284c7',
              600: '#0369a1',
              700: '#075985',
              900: '#0f172a',
              950: '#0b1120',
            }
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest" defer></script>

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="styles.css?v=3">
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-sky-500 selection:text-white">

  <!-- Scroll Progress Bar -->
  <div id="scroll-progress"></div>

  <!-- Top Emergency Status & Ticker Bar -->
  <div class="bg-slate-900 border-b border-slate-800 text-white py-2 px-4 text-xs sm:text-sm">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
      <div class="flex items-center gap-2 w-full sm:w-auto min-w-0">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
        <span class="font-bold text-emerald-400 shrink-0">Live Status:</span>
        <span class="text-slate-200 truncate">Technicians Active Across Parramatta 2150 & Western Sydney</span>
      </div>
      <div class="flex items-center gap-3 text-slate-300 overflow-hidden w-full sm:w-auto min-w-0">
        <i data-lucide="activity" class="w-4 h-4 text-sky-400 shrink-0"></i>
        <span id="live-ticker-text" class="truncate font-medium text-slate-200 min-w-0">
          ⚡ Just Booked: Commercial coolroom diagnosis in Church St, Parramatta CBD
        </span>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header id="main-header" class="sticky top-0 z-40 bg-slate-900 text-white border-b border-slate-800 transition-all duration-300 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">

      <!-- Brand Logo -->
      <a href="index.html" class="flex items-center group shrink-0">
        <div class="relative overflow-hidden rounded-lg">
          <img src="image/FFp-logo.webp" onerror="this.onerror=null; this.src='images/fridge_repair_logo.jpg';" alt="Fridge Repair Parramatta Logo" class="w-14 h-14 rounded-lg border border-sky-500/40 object-cover shadow-md group-hover:scale-105 transition-transform">
        </div>
      </a>

      <!-- Desktop Nav Links -->
      <nav class="hidden xl:flex items-center gap-4 2xl:gap-5 text-sm 2xl:text-base font-semibold text-slate-300 whitespace-nowrap">
        <a href="index.html#why-us" class="hover:text-sky-400 transition-colors">Why Us</a>
        <a href="index.html#services" class="hover:text-sky-400 transition-colors">Services</a>
        <a href="index.html#common-faults" class="hover:text-sky-400 transition-colors">Fault Finder</a>
        <a href="index.html#repair-vs-replace" class="hover:text-sky-400 transition-colors">Repair vs Replace</a>
        <a href="index.html#brands" class="hover:text-sky-400 transition-colors">Brands</a>
        <a href="index.html#suburbs" class="hover:text-sky-400 transition-colors">Suburbs</a>
        <a href="index.html#faqs" class="hover:text-sky-400 transition-colors">FAQs</a>
        <a href="about.html" class="hover:text-sky-400 transition-colors">About</a>
        <a href="blog.html" class="text-sky-400 transition-colors">Blog</a>
        <a href="contact.html" class="hover:text-sky-400 transition-colors">Contact</a>
      </nav>

      <!-- Header Action Buttons -->
      <div class="hidden sm:flex items-center gap-2 2xl:gap-3 shrink-0">
        <a href="tel:1300240680" class="flex items-center gap-2 px-3 2xl:px-4 py-2 rounded-lg text-xs 2xl:text-sm font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-500/40 hover:bg-emerald-900/80 transition-all whitespace-nowrap">
          <i data-lucide="phone-call" class="w-4 h-4 text-emerald-400"></i>
          <span>Call now</span>
        </a>
        <a href="contact.html#contact-form" class="px-3 2xl:px-4 py-2 rounded-lg text-xs 2xl:text-sm font-bold text-white bg-sky-600 hover:bg-sky-500 transition-all shadow-md whitespace-nowrap">
          Book Online 24/7
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-btn" class="xl:hidden p-2 rounded-lg text-slate-300 hover:bg-slate-800">
        <i data-lucide="menu" class="w-6 h-6"></i>
      </button>

    </div>

    <!-- Mobile Nav Dropdown -->
    <div id="mobile-menu" class="hidden xl:hidden bg-slate-900 border-b border-slate-800 px-4 py-4 space-y-3 text-sm">
      <a href="index.html#why-us" class="block text-slate-300 hover:text-sky-400 py-1">Why Choose Us</a>
      <a href="index.html#services" class="block text-slate-300 hover:text-sky-400 py-1">Services</a>
      <a href="index.html#common-faults" class="block text-slate-300 hover:text-sky-400 py-1">Fault Finder</a>
      <a href="index.html#repair-vs-replace" class="block text-slate-300 hover:text-sky-400 py-1">Repair vs Replace</a>
      <a href="index.html#brands" class="block text-slate-300 hover:text-sky-400 py-1">Brands</a>
      <a href="index.html#suburbs" class="block text-slate-300 hover:text-sky-400 py-1">Suburbs</a>
      <a href="index.html#faqs" class="block text-slate-300 hover:text-sky-400 py-1">FAQs</a>
      <a href="about.html" class="block text-slate-300 hover:text-sky-400 py-1">About</a>
      <a href="blog.html" class="block text-sky-400 py-1">Blog</a>
      <a href="contact.html" class="block text-slate-300 hover:text-sky-400 py-1">Contact</a>
      <div class="pt-3 border-t border-slate-800 flex flex-col gap-2">
        <a href="tel:1300240680" class="w-full py-2.5 rounded-lg text-center font-bold text-emerald-400 bg-emerald-950/80 border border-emerald-500/40">
          📞 Call now
        </a>
        <a href="contact.html#contact-form" class="block w-full py-2.5 rounded-lg text-center font-bold text-white bg-sky-600">
          Book Online 24/7
        </a>
      </div>
    </div>
  </header>
