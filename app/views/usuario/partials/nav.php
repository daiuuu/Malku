<?php
$_currentUrl = trim($_GET['url'] ?? '', '/');

$_navItems = [
    ['url' => 'usuario',             'label' => 'Dashboard'],
    ['url' => 'usuario/pedidos',     'label' => 'Mis Pedidos'],
    ['url' => 'usuario/perfil',      'label' => 'Mi Perfil'],
    ['url' => 'usuario/direcciones', 'label' => 'Direcciones'],
    ['url' => 'usuario/favoritos',   'label' => 'Favoritos'],
    ['url' => 'usuario/membresia',   'label' => 'Membresía Malku'],
];
?>
<nav class="usuario-nav">
    <div class="contenedor usuario-nav__inner">
        <?php foreach ($_navItems as $_item):
            $isActive = ($is_active = (
                $_currentUrl === $_item['url'] ||
                strpos($_currentUrl, $_item['url'] . '/') === 0
            ));
        ?>
        <a
            href="<?= BASE_URL ?>/<?= $_item['url'] ?>"
            class="usuario-nav__link<?= $isActive ? ' usuario-nav__link--active' : '' ?>"
        ><?= $_item['label'] ?></a>
        <?php endforeach; ?>
    </div>
</nav>
