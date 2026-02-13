(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="table-row-actions"]').forEach((menu) => {
      if (instances.has(menu)) return;
      const trigger = menu.querySelector('[data-js-trigger]');
      const panel = menu.querySelector('[data-js-panel]');
      if (!trigger || !panel) return;

      const toggle = (event) => {
        event.preventDefault();
        menu.classList.toggle('c-table-row-actions--is-open');
      };

      const onOutside = (event) => {
        if (!menu.contains(event.target)) {
          menu.classList.remove('c-table-row-actions--is-open');
        }
      };

      trigger.addEventListener('click', toggle);
      document.addEventListener('click', onOutside);
      instances.set(menu, { trigger, toggle, onOutside });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="table-row-actions"]').forEach((menu) => {
      const instance = instances.get(menu);
      if (!instance) return;
      instance.trigger.removeEventListener('click', instance.toggle);
      document.removeEventListener('click', instance.onOutside);
      instances.delete(menu);
    });
  }

  window.CComponents.register('table-row-actions', { init, destroy });
})();
