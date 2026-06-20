<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Preguntas Frecuentes</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Preguntas Frecuentes</h1>
            <p class="admin-page-subtitle"><?= count($preguntas) ?> preguntas en total</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/preguntas/crear" class="btn-admin">+ Nueva pregunta</a>
    </div>

    <?php if ($flash_ok): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <div class="admin-card">
        <?php if (empty($preguntas)): ?>
        <div class="admin-empty" style="padding:3rem 2rem;text-align:center">
            <p style="margin-bottom:1.2rem;color:var(--text-muted)">No hay preguntas creadas aún.</p>
            <a href="<?= BASE_URL ?>/admin/preguntas/crear" class="btn-admin">Crear primera pregunta</a>
        </div>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px">Orden</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                    <th style="width:80px">Estado</th>
                    <th style="width:120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($preguntas as $p): ?>
                <tr>
                    <td style="text-align:center;color:var(--text-muted);font-size:0.85rem">
                        <?= (int)$p['orden'] ?>
                    </td>
                    <td style="font-size:0.85rem;font-weight:500;max-width:280px">
                        <?= htmlspecialchars($p['pregunta']) ?>
                    </td>
                    <td style="font-size:0.82rem;color:var(--text-muted);max-width:340px">
                        <?= htmlspecialchars(mb_strimwidth($p['respuesta'], 0, 120, '…')) ?>
                    </td>
                    <td>
                        <span class="badge <?= $p['activo'] ? 'badge--activo' : 'badge--cancelado' ?>">
                            <?= $p['activo'] ? 'Activa' : 'Oculta' ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;align-items:center">
                            <a href="<?= BASE_URL ?>/admin/preguntas/editar/<?= $p['id'] ?>"
                               class="badge badge--enviado"
                               style="text-decoration:none;font-size:0.75rem">
                                Editar
                            </a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/preguntas/eliminar"
                                  onsubmit="return confirm('¿Eliminar esta pregunta?')">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit"
                                        class="badge badge--cancelado"
                                        style="border:none;cursor:pointer;font-size:0.75rem;background:none">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <p style="margin-top:1.2rem;font-size:0.8rem;color:var(--text-muted)">
        Las preguntas activas aparecen en la sección de Preguntas Frecuentes de
        <a href="<?= BASE_URL ?>/envios-devoluciones" target="_blank" style="color:var(--accent)">Envíos &amp; Devoluciones</a>.
        El campo "Orden" define el orden de aparición (menor número = primero).
    </p>

</div>
</main>
