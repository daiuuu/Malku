document.addEventListener('DOMContentLoaded', () => {
    // ================= CANTIDAD SELECTOR =================
    const cantidadMas = document.getElementById('cantidad-mas');
    const cantidadMenos = document.getElementById('cantidad-menos');
    const cantidadInput = document.getElementById('cantidad-input');

    if (cantidadMas && cantidadMenos && cantidadInput) {
        const max = parseInt(cantidadInput.getAttribute('max')) || Infinity;

        cantidadMas.addEventListener('click', (e) => {
            e.preventDefault();
            let valor = parseInt(cantidadInput.value) || 1;
            if (valor < max) {
                cantidadInput.value = valor + 1;
            }
        });

        cantidadMenos.addEventListener('click', (e) => {
            e.preventDefault();
            let valor = parseInt(cantidadInput.value) || 1;
            if (valor > 1) {
                cantidadInput.value = valor - 1;
            }
        });
    }

    const buscador = document.getElementById('buscador-productos');
    const categoriaSelect = document.querySelector('select[name="categoria"]');
    const ordenSelect = document.querySelector('select[name="orden"]');
    const productosGrid = document.querySelector('.productos-grid');
    const loadMoreBtn = document.querySelector('.load-more-btn');
    const loadMoreText = document.querySelector('.load-more-container p');
    const filtrosForms = document.querySelectorAll('.filtros form');
    const noProductsMsgClass = 'sin-productos-js';
    let currentPage = 1;
    let currentQuery = buscador ? buscador.value.trim() : '';
    let currentCategory = categoriaSelect ? categoriaSelect.value : '';
    let currentOrder = ordenSelect ? ordenSelect.value : 'nuevos';
    let moreResults = true;
    let isLoading = false;

    const debounce = (fn, wait) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    };

    const formatPrice = (price) => {
        return new Intl.NumberFormat('es-AR', { maximumFractionDigits: 0 }).format(price);
    };

    const buildUrl = (page = 1) => {
        const params = new URLSearchParams();
        if (currentQuery) params.set('buscar', currentQuery);
        if (currentCategory) params.set('categoria', currentCategory);
        if (currentOrder) params.set('orden', currentOrder);
        if (page > 1) params.set('pagina', page);
        return `${window.BASE_URL}/coleccion/buscar?${params.toString()}`;
    };

    const renderProducts = (items, append = false) => {
        if (!append) {
            productosGrid.innerHTML = '';
        }

        if (!items || items.length === 0) {
            const msg = document.createElement('p');
            msg.className = noProductsMsgClass;
            msg.textContent = 'No se encontraron productos.';
            msg.style.gridColumn = '1 / -1';
            msg.style.textAlign = 'center';
            msg.style.color = '#7C766E';
            productosGrid.appendChild(msg);
            return;
        }

        items.forEach(item => {
            const article = document.createElement('article');
            article.className = 'producto-card';
            article.dataset.name = item.nombre.toLowerCase();
            article.dataset.categoria = item.categoria_nombre.toLowerCase();

            article.innerHTML = `
                <a href="${window.BASE_URL}/producto/${encodeURIComponent(item.slug)}" class="producto-link">
                    <div class="producto-imagen">
                        <img src="${window.BASE_URL}/assets/img/${item.imagen_principal}" alt="${item.nombre}">
                        ${item.destacado ? '<span class="producto-tag">Destacado</span>' : ''}
                    </div>
                    <div class="producto-info">
                        <div class="producto-top">
                            <h3>${item.nombre}</h3>
                            <p class="precio">$${formatPrice(item.precio)}</p>
                        </div>
                        <span class="producto-color">${item.categoria_nombre}</span>
                    </div>
                </a>
            `;

            productosGrid.appendChild(article);
        });
    };

    const updateResultText = (count) => {
        if (loadMoreText) {
            loadMoreText.textContent = `Mostrando ${count} producto${count === 1 ? '' : 's'}`;
        }
    };

    const updateLoadMoreState = (hasMore) => {
        moreResults = hasMore;
        if (loadMoreBtn) {
            loadMoreBtn.style.display = hasMore ? 'inline-flex' : 'none';
        }
    };

    filtrosForms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
        });
    });

    const fetchProducts = async (page = 1, append = false) => {
        if (isLoading || !productosGrid) return;
        isLoading = true;

        if (loadMoreBtn) {
            loadMoreBtn.textContent = 'Cargando...';
            loadMoreBtn.style.pointerEvents = 'none';
        }

        try {
            const response = await fetch(buildUrl(page), { cache: 'no-store' });
            if (!response.ok) throw new Error('Error al cargar productos');

            const data = await response.json();
            if (!append) {
                productosGrid.innerHTML = '';
            }

            if (data.productos.length === 0) {
                renderProducts([], false);
                updateResultText(0);
                updateLoadMoreState(false);
            } else {
                renderProducts(data.productos, append);
                const displayed = append
                    ? productosGrid.querySelectorAll('.producto-card').length
                    : data.productos.length;
                updateResultText(displayed);
                updateLoadMoreState(data.hasMore);
            }

            currentPage = page;
        } catch (error) {
            console.error(error);
        } finally {
            isLoading = false;
            if (loadMoreBtn) {
                loadMoreBtn.textContent = 'Cargar más productos';
                loadMoreBtn.style.pointerEvents = '';
            }
        }
    };

    const resetAndFetch = () => {
        currentPage = 1;
        if (loadMoreBtn) {
            loadMoreBtn.dataset.page = '1';
        }
        fetchProducts(1, false);
    };

    if (productosGrid) {
        if (buscador) {
            buscador.addEventListener('input', debounce((event) => {
                currentQuery = event.target.value.trim();
                resetAndFetch();
            }, 300));

            buscador.closest('form')?.addEventListener('submit', (event) => {
                event.preventDefault();
                currentQuery = buscador.value.trim();
                resetAndFetch();
            });
        }

        if (categoriaSelect) {
            categoriaSelect.addEventListener('change', () => {
                currentCategory = categoriaSelect.value;
                resetAndFetch();
            });
        }

        if (ordenSelect) {
            ordenSelect.addEventListener('change', () => {
                currentOrder = ordenSelect.value;
                resetAndFetch();
            });
        }

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', (event) => {
                event.preventDefault();
                if (!moreResults) return;
                fetchProducts(currentPage + 1, true);
            });
        }
    }
});
