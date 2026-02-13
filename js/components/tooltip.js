(function () {
  const instances = new WeakMap();

  function openTooltip(el) {
    el.classList.add('c-tooltip--is-open');
    const panel = el.querySelector('[data-js-panel]');
    if (panel) panel.setAttribute('aria-hidden', 'false');
  }

  function closeTooltip(el) {
    el.classList.remove('c-tooltip--is-open');
    const panel = el.querySelector('[data-js-panel]');
    if (panel) panel.setAttribute('aria-hidden', 'true');
  }

  function init(root) {
    root.querySelectorAll('[data-js="tooltip"]').forEach((tooltip) => {
      if (instances.has(tooltip)) return;
      const trigger = tooltip.querySelector('[data-js-trigger]');
      const panel = tooltip.querySelector('[data-js-panel]');
      if (!trigger || !panel) return;

      panel.setAttribute('role', 'tooltip');
      panel.setAttribute('aria-hidden', 'true');

      const onEnter = () => openTooltip(tooltip);
      const onLeave = () => closeTooltip(tooltip);
      const onKey = (event) => {
        if (event.key === 'Escape') {
          closeTooltip(tooltip);
          trigger.focus();
        }
      };

      trigger.addEventListener('mouseenter', onEnter);
      trigger.addEventListener('focus', onEnter);
      trigger.addEventListener('mouseleave', onLeave);
      trigger.addEventListener('blur', onLeave);
      tooltip.addEventListener('keydown', onKey);

      instances.set(tooltip, { trigger, onEnter, onLeave, onKey });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="tooltip"]').forEach((tooltip) => {
      const instance = instances.get(tooltip);
      if (!instance) return;
      instance.trigger.removeEventListener('mouseenter', instance.onEnter);
      instance.trigger.removeEventListener('focus', instance.onEnter);
      instance.trigger.removeEventListener('mouseleave', instance.onLeave);
      instance.trigger.removeEventListener('blur', instance.onLeave);
      tooltip.removeEventListener('keydown', instance.onKey);
      instances.delete(tooltip);
    });
  }

  window.CComponents.register('tooltip', { init, destroy });
})();
