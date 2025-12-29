(function () {
  function qs(sel, root) {
    return (root || document).querySelector(sel);
  }

  function qsa(sel, root) {
    return Array.prototype.slice.call((root || document).querySelectorAll(sel));
  }

  function setText(el, text) {
    if (!el) return;
    el.textContent = text;
  }

  function show(el) {
    if (!el) return;
    el.classList.remove('d-none');
  }

  function hide(el) {
    if (!el) return;
    el.classList.add('d-none');
  }

  function normalize(val) {
    return String(val || '').trim();
  }

  function matches(item, category, customerType) {
    var itemCategory = normalize(item.getAttribute('data-category'));
    var itemCustomer = normalize(item.getAttribute('data-customer'));

    var okCategory = category === 'Alle' || itemCategory === category;
    var okCustomer = customerType === 'Alle' || itemCustomer === customerType;

    return okCategory && okCustomer;
  }

  function activateButton(groupEl, value) {
    if (!groupEl) return;
    qsa('button[data-filter-value]', groupEl).forEach(function (btn) {
      var isActive = normalize(btn.getAttribute('data-filter-value')) === value;
      btn.classList.toggle('active', isActive);
      btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var root = qs('[data-tffp-gallery]');
    if (!root) return;

    var categoryGroup = qs('[data-filter-group="category"]', root);
    var customerGroup = qs('[data-filter-group="customer"]', root);
    var items = qsa('[data-gallery-item]', root);

    var modal = qs('#tffp-gallery-modal', root);
    var modalBackdrop = qs('[data-modal-backdrop]', root);
    var modalClose = qs('[data-modal-close]', root);
    var modalPrev = qs('[data-modal-prev]', root);
    var modalNext = qs('[data-modal-next]', root);
    var modalTitle = qs('[data-modal-title]', root);
    var modalBadge = qs('[data-modal-badge]', root);
    var modalEmoji = qs('[data-modal-emoji]', root);
    var modalStage = qs('[data-modal-stage]', root);
    var dotsWrap = qs('[data-modal-dots]', root);

    var state = {
      category: 'Alle',
      customer: 'Alle',
      visibleItems: [],
      currentIndex: -1,
    };

    function computeVisible() {
      state.visibleItems = items.filter(function (el) {
        return !el.classList.contains('d-none');
      });
    }

    function applyFilters() {
      items.forEach(function (el) {
        var ok = matches(el, state.category, state.customer);
        if (ok) {
          el.classList.remove('d-none');
        } else {
          el.classList.add('d-none');
        }
      });

      computeVisible();
    }

    function setModalContent(itemEl) {
      if (!itemEl) return;

      var title = itemEl.getAttribute('data-title') || '';
      var category = itemEl.getAttribute('data-category') || '';
      var emoji = itemEl.getAttribute('data-emoji') || '';
      var gradient = itemEl.getAttribute('data-gradient') || '';

      setText(modalTitle, title);
      setText(modalBadge, category);
      setText(modalEmoji, emoji);

      if (modalStage) {
        modalStage.setAttribute('data-gradient', gradient);
      }
    }

    function rebuildDots() {
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';

      state.visibleItems.forEach(function (_item, idx) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'tffp-gallery-dot' + (idx === state.currentIndex ? ' active' : '');
        btn.setAttribute('aria-label', 'Ga naar item ' + (idx + 1));
        btn.addEventListener('click', function () {
          goToIndex(idx);
        });
        dotsWrap.appendChild(btn);
      });
    }

    function updateNavButtons() {
      if (modalPrev) {
        modalPrev.disabled = state.currentIndex <= 0;
      }
      if (modalNext) {
        modalNext.disabled = state.currentIndex >= state.visibleItems.length - 1;
      }
    }

    function goToIndex(idx) {
      if (idx < 0 || idx >= state.visibleItems.length) return;
      state.currentIndex = idx;
      var el = state.visibleItems[state.currentIndex];
      setModalContent(el);
      rebuildDots();
      updateNavButtons();
    }

    function openModalForItem(el) {
      computeVisible();
      var idx = state.visibleItems.indexOf(el);
      if (idx < 0) return;

      state.currentIndex = idx;
      setModalContent(el);
      rebuildDots();
      updateNavButtons();

      show(modal);
      document.body.classList.add('tffp-modal-open');

      // Focus close for accessibility.
      if (modalClose) {
        modalClose.focus();
      }
    }

    function closeModal() {
      hide(modal);
      document.body.classList.remove('tffp-modal-open');
      state.currentIndex = -1;
    }

    // Wire filter buttons
    if (categoryGroup) {
      qsa('button[data-filter-value]', categoryGroup).forEach(function (btn) {
        btn.addEventListener('click', function () {
          state.category = normalize(btn.getAttribute('data-filter-value'));
          activateButton(categoryGroup, state.category);
          applyFilters();
          closeModal();
        });
      });
    }

    if (customerGroup) {
      qsa('button[data-filter-value]', customerGroup).forEach(function (btn) {
        btn.addEventListener('click', function () {
          state.customer = normalize(btn.getAttribute('data-filter-value'));
          activateButton(customerGroup, state.customer);
          applyFilters();
          closeModal();
        });
      });
    }

    // Wire items
    items.forEach(function (el) {
      el.addEventListener('click', function () {
        openModalForItem(el);
      });
      el.setAttribute('role', 'button');
      el.setAttribute('tabindex', '0');
      el.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          openModalForItem(el);
        }
      });
    });

    // Modal controls
    if (modalClose) {
      modalClose.addEventListener('click', function () {
        closeModal();
      });
    }

    if (modalBackdrop) {
      modalBackdrop.addEventListener('click', function () {
        closeModal();
      });
    }

    if (modalPrev) {
      modalPrev.addEventListener('click', function (e) {
        e.stopPropagation();
        goToIndex(state.currentIndex - 1);
      });
    }

    if (modalNext) {
      modalNext.addEventListener('click', function (e) {
        e.stopPropagation();
        goToIndex(state.currentIndex + 1);
      });
    }

    document.addEventListener('keydown', function (e) {
      if (!modal || modal.classList.contains('d-none')) return;

      if (e.key === 'Escape') {
        closeModal();
      }

      if (e.key === 'ArrowLeft') {
        goToIndex(state.currentIndex - 1);
      }

      if (e.key === 'ArrowRight') {
        goToIndex(state.currentIndex + 1);
      }
    });

    // Initial state
    activateButton(categoryGroup, state.category);
    activateButton(customerGroup, state.customer);
    applyFilters();
    closeModal();
  });
})();
