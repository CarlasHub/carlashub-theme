(function () {
  const instances = new WeakMap();

  function init(root) {
    root.querySelectorAll('[data-js="accordion"]').forEach((accordion) => {
      if (instances.has(accordion)) return;
      const triggers = accordion.querySelectorAll('[data-js-trigger]');
      const panels = accordion.querySelectorAll('[data-js-panel]');
      panels.forEach((panel) => {
        panel.hidden = true;
      });

      const onClick = (event) => {
        const trigger = event.target.closest('[data-js-trigger]');
        if (!trigger) return;
        const controls = trigger.getAttribute('aria-controls');
        const panel = accordion.querySelector(`#${controls}`);
        const isOpen = trigger.getAttribute('aria-expanded') === 'true';
        trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
        if (panel) panel.hidden = isOpen;
        accordion.classList.toggle('c-accordion--is-open', !isOpen);
      };

      triggers.forEach((trigger) => {
        trigger.setAttribute('aria-expanded', 'false');
      });

      accordion.addEventListener('click', onClick);
      instances.set(accordion, { onClick });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="accordion"]').forEach((accordion) => {
      const instance = instances.get(accordion);
      if (!instance) return;
      accordion.removeEventListener('click', instance.onClick);
      instances.delete(accordion);
    });
  }

  window.CComponents.register('accordion', { init, destroy });
})();
