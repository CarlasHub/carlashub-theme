(function () {
  const instances = new WeakMap();

  function getFocusable(container) {
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    );
  }

  function trapFocus(modal, event) {
    if (event.key !== 'Tab') return;
    const panel = modal.querySelector('[data-js-panel]');
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

  function openModal(modal, trigger) {
    modal.classList.add('c-modal--is-open');
    modal.setAttribute('aria-hidden', 'false');
    const panel = modal.querySelector('[data-js-panel]');
    if (panel) {
      panel.setAttribute('role', 'dialog');
      panel.setAttribute('aria-modal', 'true');
      const focusable = getFocusable(panel);
      if (focusable.length) focusable[0].focus();
    }
    modal.__cLastFocus = trigger || document.activeElement;
  }

  function closeModal(modal) {
    modal.classList.remove('c-modal--is-open');
    modal.setAttribute('aria-hidden', 'true');
    if (modal.__cLastFocus) {
      modal.__cLastFocus.focus();
    }
  }

  function init(root) {
    root.querySelectorAll('[data-js="modal"]').forEach((modal) => {
      if (instances.has(modal)) return;
      modal.setAttribute('aria-hidden', 'true');
      const panel = modal.querySelector('[data-js-panel]');
      const closeButtons = modal.querySelectorAll('[data-js-close]');

      const onKey = (event) => {
        if (event.key === 'Escape') {
          closeModal(modal);
        }
        trapFocus(modal, event);
      };

      const onClose = (event) => {
        event.preventDefault();
        closeModal(modal);
      };

      const onOverlay = (event) => {
        if (panel && !panel.contains(event.target)) {
          closeModal(modal);
        }
      };

      modal.addEventListener('keydown', onKey);
      modal.addEventListener('click', onOverlay);
      closeButtons.forEach((btn) => btn.addEventListener('click', onClose));

      instances.set(modal, { onKey, onOverlay, closeButtons, onClose });
    });

    root.querySelectorAll('[data-js-trigger][data-js-target]').forEach((trigger) => {
      const targetId = trigger.getAttribute('data-js-target');
      const modal = root.querySelector(`#${targetId}`);
      if (!modal || modal.getAttribute('data-js') !== 'modal') return;
      if (trigger.__cModalBound) return;
      const onOpen = (event) => {
        event.preventDefault();
        openModal(modal, trigger);
      };
      trigger.addEventListener('click', onOpen);
      trigger.__cModalBound = onOpen;
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="modal"]').forEach((modal) => {
      const instance = instances.get(modal);
      if (!instance) return;
      modal.removeEventListener('keydown', instance.onKey);
      modal.removeEventListener('click', instance.onOverlay);
      instance.closeButtons.forEach((btn) => btn.removeEventListener('click', instance.onClose));
      instances.delete(modal);
    });
  }

  window.CComponents.register('modal', { init, destroy });
})();
