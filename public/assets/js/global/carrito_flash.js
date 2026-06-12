document.addEventListener('DOMContentLoaded', () => {
    const success = document.querySelector('.mensaje-exito');
    const error = document.querySelector('.mensaje-error');

    const hideAfter = (el, ms = 3000) => {
        if (!el) return;
        // ensure role for accessibility
        el.setAttribute('role', 'status');
        el.classList.add('show');
        setTimeout(() => {
            el.classList.remove('show');
            el.classList.add('hide');
            // remove from DOM after transition
            setTimeout(() => {
                if (el && el.parentNode) el.parentNode.removeChild(el);
            }, 400);
        }, ms);
    };

    hideAfter(success, 2600);
    hideAfter(error, 3500);
});