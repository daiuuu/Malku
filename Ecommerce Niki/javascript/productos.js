document.addEventListener('DOMContentLoaded', function () {
    const productosData = {
        "sueter-oversize-alpaca": {
            title: "Suéter Oversize de Alpaca",
            price: "$280",
            color: "Blanco crema",
            image: "../imagenes/producto1.jpg",
            description: "Un suéter amplio y suave tejido en alpaca premium. Su caída relajada y textura cálida transforman lo cotidiano en un gesto de elegancia atemporal.",
            details: [
                "100% alpaca de altura",
                "Tejido artesanal con terminaciones limpias",
                "Cuidado: lavar a mano en frío"
            ]
        },
        "cardigan-tejido-a-mano": {
            title: "Cárdigan tejido a mano",
            price: "$320",
            color: "Gris piedra",
            image: "../imagenes/producto2.jpg",
            description: "Una pieza de sastrería suave que combina líneas sobrias y volumen. Ideal para capas ligeras con un aire perfectamente imperfecto.",
            details: [
                "Mezcla de alpaca y lana merino",
                "Costuras reforzadas para mayor durabilidad",
                "Lavar con detergente suave"
            ]
        },
        "polera-lana-merino": {
            title: "Polera de lana merino",
            price: "$245",
            color: "Verde salvia",
            image: "../imagenes/producto3.jpg",
            description: "Una polera ligera y estructurada en lana merino, concebida para mantener forma y suavidad. El tono verde evoca calma y sofisticación.",
            details: [
                "Lana merino sostenible",
                "Corte ajustado con hombros suaves",
                "Planchar a baja temperatura"
            ]
        },
        "sweater-clasico-cuello-v": {
            title: "Sweater clásico cuello V",
            price: "$210",
            color: "Carbón",
            image: "../imagenes/producto4.jpg",
            description: "Un básico refinado con cuello en V y proporciones contemporáneas. Su color oscuro aporta profundidad sin estridencias.",
            details: [
                "Fibra de alpaca y lana merino",
                "Acabado pulido y minimalista",
                "Secar en plano"
            ]
        },
        "sweater-texturizado": {
            title: "Sweater texturizado",
            price: "$195",
            color: "Avena",
            image: "../imagenes/producto5.jpg",
            description: "Una textura delicada y cálida que define la prenda. Ideal para capas suaves en clave premium.",
            details: [
                "Hilo bouclé de alpaca",
                "Corte relajado y volúmenes suaves",
                "Evitar el uso de lejía"
            ]
        },
        "poncho-andino": {
            title: "Poncho andino",
            price: "$350",
            color: "Tonos tierra",
            image: "../imagenes/producto6.jpg",
            description: "Un poncho de inspiración andina con líneas puras y una textura que honra las tradiciones. Perfecto para capas suaves y composiciones elegantes.",
            details: [
                "Tejido artesanal de alpaca",
                "Bordes sin costuras visibles",
                "Usar con ropa seca"
            ]
        }
    };

    const productCards = document.querySelectorAll('.producto-card[data-product-id]');
    if (productCards.length) {
        productCards.forEach(card => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function () {
                const productId = this.dataset.productId;
                if (!productId) return;
                const targetUrl = new URL('productos.html', window.location.href);
                targetUrl.searchParams.set('id', productId);
                window.location.href = targetUrl.toString();
            });
        });
    }

    const detalle = document.getElementById('producto-detalle');
    if (!detalle) return;

    function getQueryParam(name) {
        const params = new URLSearchParams(window.location.search);
        return params.get(name);
    }

    function renderProducto(producto) {
        detalle.innerHTML = `
            <div class="producto-detail-grid">
                <div class="producto-detail-imagen">
                    <img src="${producto.image}" alt="${producto.title}">
                </div>
                <div class="producto-detail-info">
                    <span class="producto-detail-label">Producto seleccionado</span>
                    <h1>${producto.title}</h1>
                    <p class="producto-detail-price">${producto.price}</p>
                    <p class="producto-detail-color">${producto.color}</p>
                    <p class="producto-detail-description">${producto.description}</p>
                    <ul class="producto-detail-list">
                        ${producto.details.map(item => `<li>${item}</li>`).join('')}
                    </ul>
                    <a href="coleccion.html" class="producto-detail-back">Volver a colección</a>
                </div>
            </div>
        `;
    }

    const selectedProductId = getQueryParam('id');
    const product = selectedProductId ? productosData[selectedProductId] : null;

    if (product) {
        renderProducto(product);
    } else if (detalle) {
        detalle.innerHTML = `
            <div class="producto-detail-missing">
                <p>Producto no encontrado. Por favor, seleccioná un artículo desde la colección.</p>
                <a href="coleccion.html" class="producto-detail-back">Volver a colección</a>
            </div>
        `;
    }
});