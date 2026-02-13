(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="toggle"]').forEach((toggle) => {
      if (instances.has(toggle)) return;
      const input = toggle.querySelector('[data-js-input]');
      if (!input) return;

      const update = () => {
        const isChecked = input.checked;
        input.setAttribute('aria-checked', isChecked ? 'true' : 'false');
        toggle.classList.toggle('c-toggle--is-active', isChecked);
      };

      const onChange = () => update();

      input.addEventListener('change', onChange);
      update();
      instances.set(toggle, { input, onChange });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="toggle"]').forEach((toggle) => {
      const instance = instances.get(toggle);
      if (!instance) return;
      instance.input.removeEventListener('change', instance.onChange);
      instances.delete(toggle);
    });
  }

  window.CComponents.register('toggle', { init, destroy });
})();
