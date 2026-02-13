(function () {
  function init() {
    if (window.CComponents && typeof window.CComponents.initAll === "function") {
      window.CComponents.initAll(document);
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
