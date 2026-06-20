/* ============================= */
/* HAMBURGER MENU                */
/* ============================= */

const menuToggle = document.getElementById('menu-toggle');
const closeBtn   = document.getElementById('close-btn');
const canvasMenu = document.getElementById('off-canvas-menu');
const overlay    = document.getElementById('menu-overlay');

function openMenu() {
    if (!canvasMenu || !overlay) return;
    canvasMenu.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeMenu() {
    if (!canvasMenu || !overlay) return;
    canvasMenu.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

if (menuToggle) menuToggle.addEventListener('click', openMenu);
if (closeBtn)   closeBtn.addEventListener('click', closeMenu);
if (overlay)    overlay.addEventListener('click', closeMenu);

if (canvasMenu) {
    canvasMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
}

/* ============================= */
/* ACCOUNT DROPDOWN              */
/* ============================= */

const accountBtn  = document.getElementById('account-btn');
const accountMenu = document.getElementById('account-menu');

if (accountBtn && accountMenu) {

    accountBtn.addEventListener('click', e => {
        e.stopPropagation();
        const isOpen = accountMenu.classList.toggle('is-open');
        accountBtn.setAttribute('aria-expanded', isOpen);
    });

    document.addEventListener('click', e => {
        if (!accountMenu.contains(e.target) && e.target !== accountBtn) {
            accountMenu.classList.remove('is-open');
            accountBtn.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            accountMenu.classList.remove('is-open');
            accountBtn.setAttribute('aria-expanded', 'false');
            accountBtn.focus();
        }
    });

}
