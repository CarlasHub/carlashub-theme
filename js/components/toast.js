(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="toast"]').forEach((toast) => {
      if (instances.has(toast)) return;
      const onClick = (event) => {
        const close = event.target.closest('[data-js-close]');
        if (close) {
          const item = close.closest('.c-toast__item');
          if (item) item.remove();
        }
      };
      toast.addEventListener('click', onClick);
      instances.set(toast, { onClick });
    });

    root.querySelectorAll('[data-js-trigger][data-js-target]').forEach((trigger) => {
      if (trigger.__cToastBound) return;
      const targetId = trigger.getAttribute('data-js-target');
      const toast = root.querySelector(`#${targetId}`);
      if (!toast || toast.getAttribute('data-js') !== 'toast') return;
      const onOpen = (event) => {
        event.preventDefault();
        toast.classList.add('c-toast--is-open');
      };
      trigger.addEventListener('click', onOpen);
      trigger.__cToastBound = onOpen;
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="toast"]').forEach((toast) => {
      const instance = instances.get(toast);
      if (!instance) return;
      toast.removeEventListener('click', instance.onClick);
      instances.delete(toast);
    });
  }

  window.CComponents.register('toast', { init, destroy });
})();
