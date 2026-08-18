/* Fridge Repair Parramatta - Interactive Application Logic */

document.addEventListener('DOMContentLoaded', () => {
  initScrollReveal();
  initTiltCards();
  initScrollProgress();
  initHeader();
  initAgencyDropdown();
  initActiveNavLinks();
  initModals();
  initBookingWizard();
  initHeroContactForm();
  initQuoteCalculator();
  initRepairReplaceCalculator();
  initSymptomAnalyzer();
  initSuburbSearch();
  initBrandSearch();
  initFaqAccordion();
  initLiveTicker();
  initLucideIcons();
});

// "Agency" Header Dropdown (About / Blog / Reviews / Contact)
function initAgencyDropdown() {
  const btn = document.getElementById('agency-dropdown-btn');
  const panel = document.getElementById('agency-dropdown-panel');
  if (!btn || !panel) return;

  const chevron = btn.querySelector('[data-lucide="chevron-down"]');

  const closeDropdown = () => {
    panel.classList.add('hidden');
    btn.setAttribute('aria-expanded', 'false');
    if (chevron) chevron.classList.remove('rotate-180');
  };
  const openDropdown = () => {
    panel.classList.remove('hidden');
    btn.setAttribute('aria-expanded', 'true');
    if (chevron) chevron.classList.add('rotate-180');
  };

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (panel.classList.contains('hidden')) {
      openDropdown();
    } else {
      closeDropdown();
    }
  });

  document.addEventListener('click', (e) => {
    if (!panel.contains(e.target) && !btn.contains(e.target)) {
      closeDropdown();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDropdown();
  });
}

// Highlight the current page's link inside the Agency dropdown (and mobile menu equivalent)
function initActiveNavLinks() {
  const current = (window.location.pathname.split('/').pop() || 'index.html').toLowerCase();
  const isBlogPost = current.startsWith('blog-');

  document.querySelectorAll('a.agency-link').forEach(link => {
    const hrefFile = link.getAttribute('href').split('#')[0].toLowerCase();
    const isMatch = hrefFile === current || (hrefFile === 'blog.html' && isBlogPost);
    if (isMatch) {
      link.classList.remove('text-slate-300');
      link.classList.add('text-sky-400', 'font-semibold');
      const trigger = document.getElementById('agency-dropdown-btn');
      if (trigger) trigger.classList.add('text-sky-400');
    }
  });
}

// 3D Cursor-Tracked Card Tilt (skipped on touch devices & reduced-motion)
function initTiltCards() {
  const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!canHover || reduceMotion) return;

  const MAX_TILT = 7; // degrees
  const FAST_TRANSITION = 'transform 0.15s ease-out, box-shadow 0.35s ease, border-color 0.2s ease';
  const SETTLE_TRANSITION = 'transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease, border-color 0.2s ease';

  document.querySelectorAll('.card-hover').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transition = FAST_TRANSITION;
    });
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const px = (e.clientX - rect.left) / rect.width - 0.5;
      const py = (e.clientY - rect.top) / rect.height - 0.5;
      card.style.setProperty('--tilt-x', `${(-py * MAX_TILT * 2).toFixed(2)}deg`);
      card.style.setProperty('--tilt-y', `${(px * MAX_TILT * 2).toFixed(2)}deg`);
    });
    card.addEventListener('mouseleave', () => {
      card.style.transition = SETTLE_TRANSITION;
      card.style.setProperty('--tilt-x', '0deg');
      card.style.setProperty('--tilt-y', '0deg');
    });
  });
}

// Initialize Lucide SVG Icons safely
function initLucideIcons() {
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
}

// Scroll Progress Bar
function initScrollProgress() {
  const progressBar = document.getElementById('scroll-progress');
  if (!progressBar) return;
  window.addEventListener('scroll', () => {
    const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = scrolled + '%';
  });
}

// Sticky Header & Navigation
function initHeader() {
  const header = document.getElementById('main-header');
  if (!header) return;
  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      header.classList.add('shadow-md', 'bg-slate-900/95', 'py-3');
      header.classList.remove('py-5', 'bg-slate-900/80');
    } else {
      header.classList.remove('shadow-md', 'bg-slate-900/95', 'py-3');
      header.classList.add('py-5', 'bg-slate-900/80');
    }
  });

  // Mobile menu toggle
  const mobileBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  if (mobileBtn && mobileMenu) {
    mobileBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
}

// Modal Manager
function initModals() {
  // Booking Modal
  const bookingModal = document.getElementById('booking-modal');
  const openBookingBtns = document.querySelectorAll('.open-booking-modal');
  const closeBookingBtns = document.querySelectorAll('.close-booking-modal');

  openBookingBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const servicePreset = btn.getAttribute('data-service');
      const symptomPreset = btn.getAttribute('data-symptom');
      if (servicePreset && window.setBookingService) {
        window.setBookingService(servicePreset);
      }
      if (symptomPreset && window.setBookingSymptom) {
        window.setBookingSymptom(symptomPreset);
      }
      openModal(bookingModal);
    });
  });

  closeBookingBtns.forEach(btn => {
    btn.addEventListener('click', () => closeModal(bookingModal));
  });

  // Quote Modal
  const quoteModal = document.getElementById('quote-modal');
  const openQuoteBtns = document.querySelectorAll('.open-quote-modal');
  const closeQuoteBtns = document.querySelectorAll('.close-quote-modal');

  openQuoteBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal(quoteModal);
    });
  });

  closeQuoteBtns.forEach(btn => {
    btn.addEventListener('click', () => closeModal(quoteModal));
  });

  // Close modals on overlay click or Escape key
  [bookingModal, quoteModal].forEach(modal => {
    if (!modal) return;
    modal.addEventListener('click', (e) => {
      if (e.target === modal || e.target.classList.contains('modal-overlay')) {
        closeModal(modal);
      }
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeModal(bookingModal);
      closeModal(quoteModal);
    }
  });
}

function openModal(modal) {
  if (!modal) return;
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.style.overflow = 'hidden';
}

function closeModal(modal) {
  if (!modal) return;
  modal.classList.add('hidden');
  modal.classList.remove('flex');
  document.body.style.overflow = '';
}

// 4-Step Interactive Booking Wizard
function initBookingWizard() {
  let currentStep = 1;
  const wizardForm = document.getElementById('booking-wizard-form');
  if (!wizardForm) return;

  const step1 = document.getElementById('step-1');
  const step2 = document.getElementById('step-2');
  const step3 = document.getElementById('step-3');
  const step4 = document.getElementById('step-4');
  const confirmationStep = document.getElementById('step-confirmation');

  const next1 = document.getElementById('next-step-1');
  const next2 = document.getElementById('next-step-2');
  const next3 = document.getElementById('next-step-3');

  const prev2 = document.getElementById('prev-step-2');
  const prev3 = document.getElementById('prev-step-3');
  const prev4 = document.getElementById('prev-step-4');

  const stepIndicators = document.querySelectorAll('.wizard-step-indicator');

  function updateSteps(step) {
    currentStep = step;
    [step1, step2, step3, step4, confirmationStep].forEach(s => s && s.classList.add('hidden'));

    if (step === 1) step1.classList.remove('hidden');
    else if (step === 2) step2.classList.remove('hidden');
    else if (step === 3) step3.classList.remove('hidden');
    else if (step === 4) step4.classList.remove('hidden');
    else if (step === 5) confirmationStep.classList.remove('hidden');

    stepIndicators.forEach((ind, idx) => {
      const stepNum = idx + 1;
      if (stepNum === step) {
        ind.classList.add('bg-cyan-500', 'text-slate-950', 'font-bold');
        ind.classList.remove('bg-slate-800', 'text-slate-400');
      } else if (stepNum < step) {
        ind.classList.add('bg-emerald-500', 'text-slate-950');
        ind.classList.remove('bg-cyan-500', 'bg-slate-800', 'text-slate-400');
      } else {
        ind.classList.remove('bg-cyan-500', 'bg-emerald-500', 'text-slate-950');
        ind.classList.add('bg-slate-800', 'text-slate-400');
      }
    });
  }

  window.setBookingService = function(serviceType) {
    const radio = document.querySelector(`input[name="booking_service"][value="${serviceType}"]`);
    if (radio) radio.checked = true;
  };

  window.setBookingSymptom = function(symptom) {
    const select = document.getElementById('booking_symptom_select');
    if (select) select.value = symptom;
  };

  if (next1) next1.addEventListener('click', () => updateSteps(2));
  if (next2) next2.addEventListener('click', () => updateSteps(3));
  if (next3) next3.addEventListener('click', () => updateSteps(4));

  if (prev2) prev2.addEventListener('click', () => updateSteps(1));
  if (prev3) prev3.addEventListener('click', () => updateSteps(2));
  if (prev4) prev4.addEventListener('click', () => updateSteps(3));

  wizardForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = document.getElementById('book_name')?.value || 'Valued Customer';
    const phone = document.getElementById('book_phone')?.value || '';
    const suburb = document.getElementById('book_suburb')?.value || 'Parramatta';
    const refNum = 'FRP-' + Math.floor(100000 + Math.random() * 900000);

    const refElem = document.getElementById('booking-ref-number');
    const nameElem = document.getElementById('booking-customer-name');
    const suburbElem = document.getElementById('booking-customer-suburb');

    if (refElem) refElem.innerText = refNum;
    if (nameElem) nameElem.innerText = name;
    if (suburbElem) suburbElem.innerText = suburb;

    updateSteps(5);
  });

  const resetBtn = document.getElementById('reset-booking-btn');
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      wizardForm.reset();
      updateSteps(1);
      closeModal(document.getElementById('booking-modal'));
    });
  }
}

// Quote Estimator Calculator
function initQuoteCalculator() {
  const quoteForm = document.getElementById('quick-quote-form');
  const quoteResult = document.getElementById('quote-result-box');
  const estRange = document.getElementById('est-price-range');
  const estTime = document.getElementById('est-completion-time');
  const estDetails = document.getElementById('est-details-text');

  if (!quoteForm) return;

  quoteForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const serviceType = document.getElementById('quote_service_type').value;

    let price = '$150 - $320';
    let time = '45 mins - 1.5 hrs';
    let details = 'Includes upfront fixed diagnosis, genuine replacement parts, and 1-year warranty.';

    if (serviceType === 'commercial') {
      price = '$250 - $550';
      time = '1 - 2 hours';
      details = 'Priority technician dispatch, commercial grade components, 1-year warranty.';
    } else if (serviceType === 'coolroom') {
      price = '$350 - $850';
      time = '1.5 - 3 hours';
      details = 'Stock-preservation urgent priority, digital controller / leak repair, 1-year warranty.';
    } else if (serviceType === 'regas') {
      price = '$400 - $750';
      time = '2 - 3 hours';
      details = 'Full electronic leak detection, precision brazing, pressure test, vacuum & weighed gas charge.';
    } else if (serviceType === 'ice_machine') {
      price = '$220 - $480';
      time = '1 - 2 hours';
      details = 'Water valve, sensor, & harvest cycle testing + descaling recommendations.';
    }

    if (estRange) estRange.innerText = price;
    if (estTime) estTime.innerText = time;
    if (estDetails) estDetails.innerText = details;

    if (quoteResult) quoteResult.classList.remove('hidden');
  });
}

// Repair vs Replace Interactive Calculator
function initRepairReplaceCalculator() {
  const calcForm = document.getElementById('rr-calculator-form');
  const resultCard = document.getElementById('rr-result-card');
  const adviceTitle = document.getElementById('rr-advice-title');
  const adviceDesc = document.getElementById('rr-advice-desc');
  const adviceScore = document.getElementById('rr-score-badge');

  if (!calcForm) return;

  calcForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const age = parseFloat(document.getElementById('rr_age').value) || 5;
    const origPrice = parseFloat(document.getElementById('rr_orig_price').value) || 1200;
    const estRepair = parseFloat(document.getElementById('rr_est_repair').value) || 250;
    const type = document.getElementById('rr_type').value;

    // Calculation logic based on section 18 rules
    const ratio = estRepair / origPrice;
    
    if (type === 'premium') {
      if (age <= 10 && ratio < 0.6) {
        showRRResult('Repair Strongly Recommended', 'Premium French Door, Integrated or Sub-Zero units have high replacement costs ($3,000+). A repair is highly economical.', 'REPAIR (95% Value Score)', 'emerald');
      } else {
        showRRResult('Diagnostic Recommended', 'Even for older premium units, minor electronics or fan repairs are far cheaper than a full built-in replacement.', 'REPAIR (80% Value Score)', 'emerald');
      }
    } else if (age < 8 && ratio <= 0.5) {
      showRRResult('Repair Highly Economical', 'Your fridge is well under its 10-15 year lifespan. Fixing a common part (fan, thermostat, relay, seal) will restore full reliability with our 1-year warranty.', 'REPAIR (90% Value Score)', 'emerald');
    } else if (age >= 10 && ratio > 0.5) {
      showRRResult('Replacement May Be Better Value', 'For budget fridges over 10 years old with major compressor or sealed system faults, repair costs approach replacement value. We will provide honest on-site advice.', 'REPLACE (Consider New)', 'amber');
    } else {
      showRRResult('Repair Worth Doing', 'The estimated repair cost is reasonable compared to purchasing a comparable new unit. Plus, our 1-year warranty protects your repair.', 'REPAIR (75% Value Score)', 'emerald');
    }
  });

  function showRRResult(title, desc, scoreText, colorTheme) {
    if (adviceTitle) adviceTitle.innerText = title;
    if (adviceDesc) adviceDesc.innerText = desc;
    if (adviceScore) {
      adviceScore.innerText = scoreText;
      if (colorTheme === 'emerald') {
        adviceScore.className = 'inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
      } else {
        adviceScore.className = 'inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30';
      }
    }
    if (resultCard) resultCard.classList.remove('hidden');
  }
}

// Symptom Analyzer & Fault Finder Tool
function initSymptomAnalyzer() {
  const searchInput = document.getElementById('symptom-search-input');
  const symptomCards = document.querySelectorAll('.symptom-card');

  if (!symptomCards.length) return;

  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      symptomCards.forEach(card => {
        const text = card.innerText.toLowerCase();
        if (text.includes(q)) {
          card.classList.remove('hidden');
        } else {
          card.classList.add('hidden');
        }
      });
    });
  }
}

// Suburb Search & Filter
function initSuburbSearch() {
  const searchInput = document.getElementById('suburb-search-input');
  const suburbGrid = document.getElementById('suburb-grid');
  const suburbBadges = document.querySelectorAll('.suburb-badge');
  const suburbCount = document.getElementById('suburb-count');

  if (!suburbBadges.length) return;

  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      let visible = 0;

      suburbBadges.forEach(badge => {
        const text = badge.innerText.toLowerCase();
        if (text.includes(q)) {
          badge.classList.remove('hidden');
          visible++;
        } else {
          badge.classList.add('hidden');
        }
      });

      if (suburbCount) {
        suburbCount.innerText = visible;
      }
    });
  }
}

// Brand Search & Category Filter
function initBrandSearch() {
  const searchInput = document.getElementById('brand-search-input');
  const brandChips = document.querySelectorAll('.brand-chip');

  if (!brandChips.length) return;

  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      brandChips.forEach(chip => {
        const text = chip.innerText.toLowerCase();
        if (text.includes(q)) {
          chip.classList.remove('hidden');
        } else {
          chip.classList.add('hidden');
        }
      });
    });
  }
}

// FAQ Accordion & Live Search
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item');
  const faqSearch = document.getElementById('faq-search-input');

  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question');
    const answerDiv = item.querySelector('.faq-answer');
    const icon = item.querySelector('.faq-icon');

    if (questionBtn && answerDiv) {
      questionBtn.addEventListener('click', () => {
        const isOpen = answerDiv.classList.contains('active');

        // Close all other FAQs
        faqItems.forEach(otherItem => {
          const otherAns = otherItem.querySelector('.faq-answer');
          const otherIcon = otherItem.querySelector('.faq-icon');
          if (otherAns) otherAns.classList.remove('active');
          if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
        });

        if (!isOpen) {
          answerDiv.classList.add('active');
          if (icon) icon.style.transform = 'rotate(180deg)';
        }
      });
    }
  });

  if (faqSearch) {
    faqSearch.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      faqItems.forEach(item => {
        const text = item.innerText.toLowerCase();
        if (text.includes(q)) {
          item.classList.remove('hidden');
        } else {
          item.classList.add('hidden');
        }
      });
    });
  }
}

// Live Dispatch Ticker Simulation
function initLiveTicker() {
  const tickerText = document.getElementById('live-ticker-text');
  if (!tickerText) return;

  const dispatches = [
    "⚡ Just Booked: Commercial coolroom diagnosis in Church St, Parramatta CBD",
    "✅ Completed: Samsung French Door defrost repair in Westmead (1-Yr Warranty Issued)",
    "⏱️ Emergency Callout: Medical vaccine fridge alert dispatched to Northmead",
    "⚡ Just Booked: Freezer repair & seal replacement in Harris Park",
    "✅ Completed: Skope commercial bar fridge regas in Rosehill",
    "⚡ Just Booked: Westinghouse top-mount fan motor replacement in Granville 2142"
  ];

  let idx = 0;
  setInterval(() => {
    idx = (idx + 1) % dispatches.length;
    tickerText.style.opacity = '0';
    setTimeout(() => {
      tickerText.innerText = dispatches[idx];
      tickerText.style.opacity = '1';
    }, 300);
  }, 4500);
}

// Hero Contact Form Handler
function initHeroContactForm() {
  const heroForm = document.getElementById('hero-contact-form');
  const successBox = document.getElementById('hero-form-success');
  if (!heroForm) return;

  heroForm.addEventListener('submit', (e) => {
    e.preventDefault();
    heroForm.classList.add('hidden');
    if (successBox) successBox.classList.remove('hidden');
  });
}

// Scroll Reveal Animations
function initScrollReveal() {
  const sections = document.querySelectorAll('body > section, body > footer');
  if (!sections.length) return;

  // Add scroll-reveal class to all sections
  sections.forEach((section, index) => {
    section.classList.add('scroll-reveal');
    // Immediately reveal hero (first section) so it's visible on load
    if (index === 0) {
      section.classList.add('revealed');
    }
  });

  // Use IntersectionObserver for performant scroll detection
  const observerOptions = {
    root: null,
    rootMargin: '0px 0px -60px 0px',
    threshold: 0.08
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  sections.forEach((section, index) => {
    // Skip hero section (already revealed)
    if (index > 0) {
      observer.observe(section);
    }
  });
}
