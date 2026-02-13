(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="file-upload"]').forEach((wrapper) => {
      if (instances.has(wrapper)) return;
      const input = wrapper.querySelector('[data-js-input]');
      const filename = wrapper.querySelector('[data-js-filename]');
      if (!input || !filename) return;

      const onChange = () => {
        const files = input.files;
        if (!files || !files.length) {
          filename.textContent = 'No file selected';
          return;
        }
        filename.textContent = Array.from(files).map((file) => file.name).join(', ');
      };

      input.addEventListener('change', onChange);
      instances.set(wrapper, { input, onChange });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="file-upload"]').forEach((wrapper) => {
      const instance = instances.get(wrapper);
      if (!instance) return;
      instance.input.removeEventListener('change', instance.onChange);
      instances.delete(wrapper);
    });
  }

  window.CComponents.register('file-upload', { init, destroy });
})();
