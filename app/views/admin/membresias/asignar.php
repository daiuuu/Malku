<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/membresias">Membresías</a>
        <span>›</span>
        <span><?= $membresia ? 'Editar' : 'Asignar' ?></span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">
                <?= $membresia ? 'Editar membresía' : 'Asignar membresía' ?>
            </h1>
            <p class="admin-page-subtitle">
                <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?>
                &mdash; <?= htmlspecialchars($usuario['email']) ?>
            </p>
        </div>
    </div>

    <div class="admin-card" style="max-width:580px">

        <form method="POST" action="<?= BASE_URL ?>/admin/membresias/guardar" class="admin-form">
            <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">

            <div class="form-row">

                <div class="form-field">
                    <label>Nivel de membresía</label>
                    <select name="tipo">
                        <option value="basica"
                            <?= ($membresia['tipo'] ?? 'basica') === 'basica' ? 'selected' : '' ?>>
                            Bronce (Básica)
                        </option>
                        <option value="premium"
                            <?= ($membresia['tipo'] ?? '') === 'premium' ? 'selected' : '' ?>>
                            Plata (Premium)
                        </option>
                        <option value="exclusive"
                            <?= ($membresia['tipo'] ?? '') === 'exclusive' ? 'selected' : '' ?>>
                            Oro (Exclusiva)
                        </option>
                    </select>
                </div>

                <div class="form-field">
                    <label>Estado</label>
                    <select name="estado">
                        <option value="activa"
                            <?= ($membresia['estado'] ?? 'activa') === 'activa' ? 'selected' : '' ?>>
                            Activa
                        </option>
                        <option value="vencida"
                            <?= ($membresia['estado'] ?? '') === 'vencida' ? 'selected' : '' ?>>
                            Vencida
                        </option>
                        <option value="cancelada"
                            <?= ($membresia['estado'] ?? '') === 'cancelada' ? 'selected' : '' ?>>
                            Cancelada
                        </option>
                    </select>
                </div>

            </div>

            <div class="form-row">

                <div class="form-field">
                    <label>Fecha de inicio</label>
                    <input
                        type="date"
                        name="fecha_inicio"
                        value="<?= !empty($membresia['fecha_inicio'])
                            ? date('Y-m-d', strtotime($membresia['fecha_inicio']))
                            : date('Y-m-d') ?>"
                    >
                </div>

                <div class="form-field">
                    <label>Fecha de vencimiento</label>
                    <input
                        type="date"
                        name="fecha_expiracion"
                        value="<?= !empty($membresia['fecha_expiracion'])
                            ? date('Y-m-d', strtotime($membresia['fecha_expiracion']))
                            : date('Y-m-d', strtotime('+1 year')) ?>"
                    >
                </div>

            </div>

            <div class="form-field">
                <label style="flex-direction:row;align-items:center;gap:10px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:0.85rem;font-weight:400">
                    <input
                        type="checkbox"
                        name="renovacion_automatica"
                        value="1"
                        <?= !empty($membresia['renovacion_automatica']) ? 'checked' : '' ?>
                    >
                    Renovar automáticamente al vencer
                </label>
            </div>

            <div class="form-actions" style="margin-top:28px">
                <button type="submit" class="btn-admin">
                    <?= $membresia ? 'Guardar cambios' : 'Asignar membresía' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/membresias" class="btn-admin-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</div>
</main>
