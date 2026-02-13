(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="search-input"]').forEach((wrapper) => {
      if (instances.has(wrapper)) return;
      const input = wrapper.querySelector('[data-js-input]');
      const clear = wrapper.querySelector('[data-js-clear]');
      if (!input || !clear) return;

      const onClear = (event) => {
        event.preventDefault();
        input.value = '';
        input.focus();
      };

      clear.addEventListener('click', onClear);
      instances.set(wrapper, { clear, onClear });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="search-input"]').forEach((wrapper) => {
      const instance = instances.get(wrapper);
      if (!instance) return;
      instance.clear.removeEventListener('click', instance.onClear);
      instances.delete(wrapper);
    });
  }

  window.CComponents.register('search-input', { init, destroy });
})();
