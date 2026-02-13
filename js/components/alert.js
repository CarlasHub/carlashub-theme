(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="alert"]').forEach((alert) => {
      if (instances.has(alert)) return;
      const close = alert.querySelector('[data-js-close]');
      if (!close) return;
      const onClose = (event) => {
        event.preventDefault();
        alert.remove();
      };
      close.addEventListener('click', onClose);
      instances.set(alert, { close, onClose });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="alert"]').forEach((alert) => {
      const instance = instances.get(alert);
      if (!instance) return;
      instance.close.removeEventListener('click', instance.onClose);
      instances.delete(alert);
    });
  }

  window.CComponents.register('alert', { init, destroy });
})();
