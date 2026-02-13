(() => {
  const root = document.documentElement;
  root.classList.add('has-js');

  const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  const updateMotion = () => {
    if (motionQuery.matches) {
      root.classList.add('reduced-motion');
    } else {
      root.classList.remove('reduced-motion');
    }
  };

  updateMotion();
  if (motionQuery.addEventListener) {
    motionQuery.addEventListener('change', updateMotion);
  } else if (motionQuery.addListener) {
    motionQuery.addListener(updateMotion);
  }
})();
