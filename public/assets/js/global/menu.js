const menuToggle = document.getElementById("menu-toggle");
const closeBtn = document.getElementById("close-btn");
const offCanvasMenu = document.getElementById("off-canvas-menu");
const overlay = document.getElementById("menu-overlay");

/* ============================= */
/* ABRIR MENU */
/* ============================= */

menuToggle.addEventListener("click", () => {

    offCanvasMenu.classList.add("active");
    overlay.classList.add("active");

});

/* ============================= */
/* CERRAR MENU */
/* ============================= */

function closeMenu() {

    offCanvasMenu.classList.remove("active");
    overlay.classList.remove("active");

}

closeBtn.addEventListener("click", closeMenu);

overlay.addEventListener("click", closeMenu);

/* ============================= */
/* CERRAR AL HACER CLICK EN LINK */
/* ============================= */

const menuLinks = offCanvasMenu.querySelectorAll("a");

menuLinks.forEach(link => {

    link.addEventListener("click", () => {

        closeMenu();

    });

});