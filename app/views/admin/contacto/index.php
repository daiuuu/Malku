<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Mensajes</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Mensajes de contacto</h1>
            <p class="admin-page-subtitle"><?= count($mensajes) ?> mensajes recibidos.</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <?php if (empty($mensajes)): ?>
    <div class="admin-empty"><p>No hay mensajes todavía.</p></div>
    <?php else: ?>

    <div style="display:flex;flex-direction:column;gap:1rem;">
    <?php foreach ($mensajes as $m): ?>

        <div class="admin-card contacto-card" id="msg-<?= $m['id'] ?>">

            <!-- CABECERA DEL MENSAJE -->
            <div class="contacto-card__head">
                <div class="contacto-card__meta">
                    <span class="contacto-card__nombre"><?= htmlspecialchars($m['nombre'] ?? '—') ?></span>
                    <a href="mailto:<?= htmlspecialchars($m['email'] ?? '') ?>" class="contacto-card__email">
                        <?= htmlspecialchars($m['email'] ?? '—') ?>
                    </a>
                </div>
                <div class="contacto-card__right">
                    <span class="badge badge--<?= $m['estado'] ?? 'pendiente' ?>"><?= ucfirst($m['estado'] ?? 'pendiente') ?></span>
                    <span class="contacto-card__fecha">
                        <?= isset($m['fecha_envio']) ? date('d/m/Y H:i', strtotime($m['fecha_envio'])) : '—' ?>
                    </span>
                </div>
            </div>

            <!-- ASUNTO Y MENSAJE -->
            <div class="contacto-card__body">
                <p class="contacto-card__asunto"><?= htmlspecialchars($m['asunto'] ?? '') ?></p>
                <p class="contacto-card__mensaje"><?= nl2br(htmlspecialchars($m['mensaje'] ?? '')) ?></p>
            </div>

            <!-- ACCIONES -->
            <div class="contacto-card__footer">

                <!-- CAMBIAR ESTADO -->
                <form method="POST" action="<?= BASE_URL ?>/admin/contacto/cambiar-estado" style="display:flex;gap:0.5rem;align-items:center">
                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                    <select name="estado" class="contacto-select">
                        <option value="pendiente"  <?= ($m['estado'] ?? '') === 'pendiente'  ? 'selected' : '' ?>>Pendiente</option>
                        <option value="leido"      <?= ($m['estado'] ?? '') === 'leido'      ? 'selected' : '' ?>>Leído</option>
                        <option value="respondido" <?= ($m['estado'] ?? '') === 'respondido' ? 'selected' : '' ?>>Respondido</option>
                    </select>
                    <button type="submit" class="btn-admin-secondary btn-admin-sm">Actualizar</button>
                </form>

                <!-- ABRIR RESPUESTA -->
                <button
                    class="btn-admin btn-admin-sm"
                    onclick="toggleRespuesta(<?= $m['id'] ?>)"
                    id="btn-responder-<?= $m['id'] ?>"
                >
                    Responder
                </button>

            </div>

            <!-- PANEL DE RESPUESTA (oculto por defecto) -->
            <div class="contacto-reply" id="reply-<?= $m['id'] ?>" style="display:none">
                <form method="POST" action="<?= BASE_URL ?>/admin/contacto/responder">
                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                    <div class="contacto-reply__inner">
                        <label class="contacto-reply__label">
                            Respuesta para <?= htmlspecialchars($m['nombre'] ?? '') ?> (<?= htmlspecialchars($m['email'] ?? '') ?>)
                        </label>
                        <textarea
                            name="respuesta"
                            class="contacto-reply__textarea"
                            rows="5"
                            placeholder="Escribí tu respuesta aquí..."
                            required
                        ></textarea>
                        <div class="contacto-reply__actions">
                            <button type="submit" class="btn-admin btn-admin-sm">Enviar respuesta por email</button>
                            <button type="button" class="btn-admin-secondary btn-admin-sm" onclick="toggleRespuesta(<?= $m['id'] ?>)">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    <?php endforeach; ?>
    </div>

    <?php endif; ?>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
