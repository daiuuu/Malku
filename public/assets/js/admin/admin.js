// ── Modal confirmación (productos, categorías) ───────────────────────────
function confirmarEliminar(id, nombre) {
    document.getElementById('modal-id').value = id;
    document.getElementById('modal-msg').textContent = '¿Querés ocultar "' + nombre + '"?';
    document.getElementById('modal-eliminar').classList.add('active');
}

function cerrarModal() {
    var modal = document.getElementById('modal-eliminar');
    if (modal) modal.classList.remove('active');
}

(function () {
    var modal = document.getElementById('modal-eliminar');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) cerrarModal();
        });
    }
})();

// ── Panel de respuesta (contacto) ────────────────────────────────────────
function toggleRespuesta(id) {
    var panel = document.getElementById('reply-' + id);
    var btn   = document.getElementById('btn-responder-' + id);
    if (!panel) return;
    if (panel.style.display === 'none') {
        panel.style.display = 'block';
        btn.textContent = 'Cancelar';
        var ta = panel.querySelector('textarea');
        if (ta) ta.focus();
    } else {
        panel.style.display = 'none';
        btn.textContent = 'Responder';
    }
}
