document.addEventListener('DOMContentLoaded', () => {
	const nav = document.querySelector('#site-navigation');
	const toggle = document.querySelector('#primary-menu-toggle');
	const panel = document.querySelector('#primary-menu-container');
	const closeButton = document.querySelector('#primary-menu-close');

	if (!nav || !toggle || !panel) {
		return;
	}

	const media = window.matchMedia('(max-width: 1100px)');
	const focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

	const getFocusableElements = () => {
		const elements = Array.from(panel.querySelectorAll(focusableSelector));

		return elements.filter((element) => !element.hidden && element.offsetParent !== null);
	};

	const handlePanelKeydown = (event) => {
		if (!media.matches || nav.getAttribute('data-nav-state') !== 'open') {
			return;
		}

		if (event.key === 'Escape') {
			event.preventDefault();
			applyState(false, { restoreFocus: true });
			return;
		}

		if (event.key !== 'Tab') {
			return;
		}

		const focusableElements = getFocusableElements();

		if (!focusableElements.length) {
			event.preventDefault();
			panel.focus();
			return;
		}

		const firstElement = focusableElements[0];
		const lastElement = focusableElements[focusableElements.length - 1];

		if (event.shiftKey && document.activeElement === firstElement) {
			event.preventDefault();
			lastElement.focus();
			return;
		}

		if (!event.shiftKey && document.activeElement === lastElement) {
			event.preventDefault();
			firstElement.focus();
		}
	};

	const applyState = (expanded, options = {}) => {
		const isMobile = media.matches;
		const open = isMobile ? Boolean(expanded) : true;

		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		nav.setAttribute('data-nav-state', open ? 'open' : 'closed');
		panel.hidden = !open && isMobile;
		document.body.classList.toggle('menu-open', open && isMobile);

		document.removeEventListener('keydown', handlePanelKeydown);

		if (open && isMobile) {
			document.addEventListener('keydown', handlePanelKeydown);
			window.requestAnimationFrame(() => {
				if (closeButton) {
					closeButton.focus();
					return;
				}

				panel.focus();
			});
			return;
		}

		if (options.restoreFocus && toggle) {
			toggle.focus();
		}
	};

	const syncLayout = () => {
		toggle.hidden = !media.matches;
		if (media.matches) {
			panel.setAttribute('tabindex', '-1');
		} else {
			panel.removeAttribute('tabindex');
		}
		applyState(!media.matches);
	};

	toggle.addEventListener('click', (event) => {
		event.preventDefault();
		const expanded = toggle.getAttribute('aria-expanded') === 'true';
		applyState(!expanded);
	});

	if (closeButton) {
		closeButton.addEventListener('click', (event) => {
			event.preventDefault();
			applyState(false, { restoreFocus: true });
		});
	}

	if (typeof media.addEventListener === 'function') {
		media.addEventListener('change', syncLayout);
	} else if (typeof media.addListener === 'function') {
		media.addListener(syncLayout);
	}

	syncLayout();
});
