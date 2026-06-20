<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label"><a href="<?= BASE_URL ?>/usuario/direcciones" style="color:inherit">Direcciones</a> / Nueva</span>
        <h1 class="u-page-header__title">Nueva dirección</h1>
    </div>

    <div class="u-card">
        <form action="<?= BASE_URL ?>/usuario/direcciones/guardar" method="POST">
            <div class="u-form-grid">

                <div class="u-form-group">
                    <label for="nombre_recibe">Nombre de quien recibe *</label>
                    <input type="text" id="nombre_recibe" name="nombre_recibe" required>
                </div>
                <div class="u-form-group">
                    <label for="telefono">Teléfono de contacto</label>
                    <input type="text" id="telefono" name="telefono">
                </div>

                <div class="u-form-group">
                    <label for="calle">Calle *</label>
                    <input type="text" id="calle" name="calle" required>
                </div>
                <div class="u-form-group">
                    <label for="numero">Número *</label>
                    <input type="text" id="numero" name="numero" required>
                </div>

                <div class="u-form-group">
                    <label for="piso">Piso</label>
                    <input type="text" id="piso" name="piso">
                </div>
                <div class="u-form-group">
                    <label for="departamento">Departamento</label>
                    <input type="text" id="departamento" name="departamento">
                </div>

                <div class="u-form-group">
                    <label for="ciudad">Ciudad / Localidad *</label>
                    <input type="text" id="ciudad" name="ciudad" required>
                </div>
                <div class="u-form-group">
                    <label for="provincia">Provincia *</label>
                    <input type="text" id="provincia" name="provincia" required>
                </div>

                <div class="u-form-group">
                    <label for="codigo_postal">Código Postal</label>
                    <input type="text" id="codigo_postal" name="codigo_postal">
                </div>

                <div class="u-form-group u-form-group--full">
                    <label for="referencia">Referencia (observaciones)</label>
                    <input type="text" id="referencia" name="referencia" placeholder="Ej: Timbre en puerta azul, dejar con portero">
                </div>

                <div class="u-form-group u-form-group--full">
                    <label class="u-form-check">
                        <input type="checkbox" name="principal" value="1">
                        Usar como dirección principal
                    </label>
                </div>

            </div>

            <div class="u-btn-row">
                <button type="submit" class="u-btn u-btn--dark">Guardar dirección</button>
                <a href="<?= BASE_URL ?>/usuario/direcciones" class="u-btn u-btn--outline">Cancelar</a>
            </div>
        </form>
    </div>

</div>
</main>
