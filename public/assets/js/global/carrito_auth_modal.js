// =========================================
// MODAL AUTH MALKU
// =========================================

document.addEventListener(
    'DOMContentLoaded',
    () =>
    {
        // ================= ELEMENTOS =================
        const BOTON_ABRIR =
            document.getElementById(
                'abrir-login-modal'
            );

        const MODAL =
            document.getElementById(
                'modal-auth'
            );

        const BOTON_CERRAR =
            document.getElementById(
                'cerrar-modal-auth'
            );

        // ================= ABRIR =================
        if(BOTON_ABRIR)
        {
            BOTON_ABRIR.addEventListener(
                'click',
                () =>
                {
                    MODAL.classList.add(
                        'activo'
                    );

                    document.body.style.overflow =
                        'hidden';
                }
            );
        }

        // ================= CERRAR =================
        if(BOTON_CERRAR)
        {
            BOTON_CERRAR.addEventListener(
                'click',
                cerrarModal
            );
        }

        // ================= CLICK OVERLAY =================
        if(MODAL)
        {
            MODAL.addEventListener(
                'click',
                (e) =>
                {
                    if(e.target === MODAL)
                    {
                        cerrarModal();
                    }
                }
            );
        }

        // ================= ESC =================
        document.addEventListener(
            'keydown',
            (e) =>
            {
                if(
                    e.key === 'Escape' &&
                    MODAL.classList.contains(
                        'activo'
                    )
                )
                {
                    cerrarModal();
                }
            }
        );

        // ================= FUNCIÓN =================
        function cerrarModal()
        {
            MODAL.classList.remove(
                'activo'
            );

            document.body.style.overflow =
                'auto';
        }
    }
);