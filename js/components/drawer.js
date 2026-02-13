(function () {
  const instances = new WeakMap();

  function getFocusable(container) {
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    );
  }

  function trapFocus(drawer, event) {
    if (event.key !== 'Tab') return;
    const panel = drawer.querySelector('[data-js-panel]');
    if (!panel) return;
    const focusable = getFocusable(panel);
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  function openDrawer(drawer, trigger) {
    drawer.classList.add('c-drawer--is-open');
    drawer.setAttribute('aria-hidden', 'false');
    const panel = drawer.querySelector('[data-js-panel]');
    if (panel) {
      panel.setAttribute('role', 'dialog');
      panel.setAttribute('aria-modal', 'true');
      const focusable = getFocusable(panel);
      if (focusable.length) focusable[0].focus();
    }
    drawer.__cLastFocus = trigger || document.activeElement;
  }

  function closeDrawer(drawer) {
    drawer.classList.remove('c-drawer--is-open');
    drawer.setAttribute('aria-hidden', 'true');
    if (drawer.__cLastFocus) {
      drawer.__cLastFocus.focus();
    }
  }

  function init(root) {
    root.querySelectorAll('[data-js="drawer"]').forEach((drawer) => {
      if (instances.has(drawer)) return;
      drawer.setAttribute('aria-hidden', 'true');
      const panel = drawer.querySelector('[data-js-panel]');
      const closeButtons = drawer.querySelectorAll('[data-js-close]');

      const onKey = (event) => {
        if (event.key === 'Escape') {
          closeDrawer(drawer);
        }
        trapFocus(drawer, event);
      };

      const onClose = (event) => {
        event.preventDefault();
        closeDrawer(drawer);
      };

      const onOverlay = (event) => {
        if (panel && !panel.contains(event.target)) {
          closeDrawer(drawer);
        }
      };

      drawer.addEventListener('keydown', onKey);
      drawer.addEventListener('click', onOverlay);
      closeButtons.forEach((btn) => btn.addEventListener('click', onClose));

      instances.set(drawer, { onKey, onOverlay, closeButtons, onClose });
    });

    root.querySelectorAll('[data-js-trigger][data-js-target]').forEach((trigger) => {
      const targetId = trigger.getAttribute('data-js-target');
      const drawer = root.querySelector(`#${targetId}`);
      if (!drawer || drawer.getAttribute('data-js') !== 'drawer') return;
      if (trigger.__cDrawerBound) return;
      const onOpen = (event) => {
        event.preventDefault();
        openDrawer(drawer, trigger);
      };
      trigger.addEventListener('click', onOpen);
      trigger.__cDrawerBound = onOpen;
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="drawer"]').forEach((drawer) => {
      const instance = instances.get(drawer);
      if (!instance) return;
      drawer.removeEventListener('keydown', instance.onKey);
      drawer.removeEventListener('click', instance.onOverlay);
      instance.closeButtons.forEach((btn) => btn.removeEventListener('click', instance.onClose));
      instances.delete(drawer);
    });
  }

  window.CComponents.register('drawer', { init, destroy });
})();
