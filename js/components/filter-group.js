(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="filter-group"]').forEach((group) => {
      if (instances.has(group)) return;
      const toggle = group.querySelector('[data-js-trigger]');
      const panel = group.querySelector('[data-js-panel]');
      if (!toggle || !panel) return;

      const onToggle = (event) => {
        event.preventDefault();
        const isOpen = group.classList.toggle('c-filter-group--is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        panel.hidden = !isOpen;
      };

      toggle.setAttribute('aria-expanded', 'false');
      panel.hidden = true;
      toggle.addEventListener('click', onToggle);
      instances.set(group, { toggle, onToggle, panel });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="filter-group"]').forEach((group) => {
      const instance = instances.get(group);
      if (!instance) return;
      instance.toggle.removeEventListener('click', instance.onToggle);
      instances.delete(group);
    });
  }

  window.CComponents.register('filter-group', { init, destroy });
})();
