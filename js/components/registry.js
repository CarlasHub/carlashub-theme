(function () {
  const modules = {};

  function register(name, module) {
    modules[name] = module;
  }

  function initAll(root) {
    Object.values(modules).forEach((module) => {
      if (module && typeof module.init === "function") {
        module.init(root || document);
      }
    });
  }

  function destroyAll(root) {
    Object.values(modules).forEach((module) => {
      if (module && typeof module.destroy === "function") {
        module.destroy(root || document);
      }
    });
  }

  window.CComponents = {
    register,
    initAll,
    destroyAll,
  };
})();
