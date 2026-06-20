document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mensaje-error, .mensaje-exito').forEach(function (el) {
        setTimeout(function () {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(function () { el.remove(); }, 500);
        }, 4500);
    });
});
