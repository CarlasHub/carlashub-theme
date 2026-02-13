(function () {
  const instances = new WeakMap();

  function activateTab(tabs, tab) {
    const tabList = tabs.querySelector('[data-js-tablist]');
    const tabsButtons = tabs.querySelectorAll('[data-js-tab]');
    const panels = tabs.querySelectorAll('[data-js-panel]');

    tabsButtons.forEach((btn) => {
      const isActive = btn === tab;
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
      btn.setAttribute('tabindex', isActive ? '0' : '-1');
    });

    panels.forEach((panel) => {
      const controls = tab.getAttribute('aria-controls');
      panel.hidden = panel.id !== controls;
    });
  }

  function init(root) {
    root.querySelectorAll('[data-js="tabs"]').forEach((tabs) => {
      if (instances.has(tabs)) return;
      const tabList = tabs.querySelector('[data-js-tablist]');
      const tabButtons = tabs.querySelectorAll('[data-js-tab]');
      const panels = tabs.querySelectorAll('[data-js-panel]');

      if (!tabList || !tabButtons.length || !panels.length) return;

      tabList.setAttribute('role', 'tablist');
      tabButtons.forEach((btn, index) => {
        btn.setAttribute('role', 'tab');
        btn.setAttribute('tabindex', index === 0 ? '0' : '-1');
        btn.setAttribute('aria-selected', index === 0 ? 'true' : 'false');
      });
      panels.forEach((panel, index) => {
        panel.setAttribute('role', 'tabpanel');
        panel.hidden = index !== 0;
      });

      const onClick = (event) => {
        const target = event.target.closest('[data-js-tab]');
        if (!target) return;
        activateTab(tabs, target);
      };

      const onKey = (event) => {
        const current = document.activeElement.closest('[data-js-tab]');
        if (!current) return;
        const list = Array.from(tabButtons);
        let nextIndex = list.indexOf(current);
        if (event.key === 'ArrowRight') nextIndex += 1;
        if (event.key === 'ArrowLeft') nextIndex -= 1;
        if (event.key === 'Home') nextIndex = 0;
        if (event.key === 'End') nextIndex = list.length - 1;
        if (nextIndex !== list.indexOf(current)) {
          event.preventDefault();
          const next = list[(nextIndex + list.length) % list.length];
          next.focus();
          activateTab(tabs, next);
        }
      };

      tabs.addEventListener('click', onClick);
      tabs.addEventListener('keydown', onKey);
      instances.set(tabs, { onClick, onKey });
    });
  }

  function destroy(root) {
    root.querySelectorAll('[data-js="tabs"]').forEach((tabs) => {
      const instance = instances.get(tabs);
      if (!instance) return;
      tabs.removeEventListener('click', instance.onClick);
      tabs.removeEventListener('keydown', instance.onKey);
      instances.delete(tabs);
    });
  }

  window.CComponents.register('tabs', { init, destroy });
})();
