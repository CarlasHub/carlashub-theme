(function () {
  const instances = new WeakMap();

  function closeDropdown(dropdown) {
    dropdown.classList.remove('c-dropdown--is-open');
    const trigger = dropdown.querySelector('[data-js-trigger]');
    const panel = dropdown.querySelector('[data-js-panel]');
    if (trigger) trigger.setAttribute('aria-expanded', 'false');
    if (panel) panel.setAttribute('aria-hidden', 'true');
  }

  function openDropdown(dropdown) {
    dropdown.classList.add('c-dropdown--is-open');
    const trigger = dropdown.querySelector('[data-js-trigger]');
    const panel = dropdown.querySelector('[data-js-panel]');
    if (trigger) trigger.setAttribute('aria-expanded', 'true');
    if (panel) panel.setAttribute('aria-hidden', 'false');
  }

  function init(root) {
    root.querySelectorAll('[data-js="dropdown"]').forEach((dropdown) => {
      if (instances.has(dropdown)) return;
      const trigger = dropdown.querySelector('[data-js-trigger]');
      const panel = dropdown.querySelector('[data-js-panel]');
      if (!trigger || !panel) return;

      panel.setAttribute('role', 'menu');
      panel.setAttribute('aria-hidden', 'true');
      trigger.setAttribute('aria-haspopup', 'menu');
      trigger.setAttribute('aria-expanded', 'false');

      const onToggle = (event) => {
        event.preventDefault();
        const isOpen = dropdown.classList.contains('c-dropdown--is-open');
        if (isOpen) {
          closeDropdown(dropdown);
        } else {
          openDropdown(dropdown);
        }
      };

      const onKey = (event) => {
        if (event.key === 'Escape') {
          closeDropdown(dropdown);
          trigger.focus();
        }
      };

      const onOutside = (event) => {
        if (!dropdown.contains(event.target)) {
          closeDropdown(dropdown);
        }
      };

      trigger.addEventListener('click', onToggle);
      dropdown.addEventListener('keydown', onKey);
      document.addEventListener('click', onOutside);

      instances.set(dropdown, { trigger, onToggle, onKey, onOutside });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="dropdown"]').forEach((dropdown) => {
      const instance = instances.get(dropdown);
      if (!instance) return;
      instance.trigger.removeEventListener('click', instance.onToggle);
      dropdown.removeEventListener('keydown', instance.onKey);
      document.removeEventListener('click', instance.onOutside);
      instances.delete(dropdown);
    });
  }

  window.CComponents.register('dropdown', { init, destroy });
})();
