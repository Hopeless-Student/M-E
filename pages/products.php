<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Catalog</title>
    <link rel="stylesheet" href="../assets/css/products.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/homepage.css">

</head>
<body>
  <?php include '../includes/navbar.php'; ?>


    <div class="toolbar">
        <div class="dropdown" onmouseleave="hideMenu('catMenu')">
            <button class="drop-btn" onclick="toggleMenu('catMenu')">Categories ▾</button>
            <div class="menu" id="catMenu">
                <ul>
                    <li onclick="setFilter('category','all')">All</li>
                    <li onclick="setFilter('category','School Supplies')">School Supplies</li>
                    <li onclick="setFilter('category','Office Supplies')">Office Supplies</li>
                    <li onclick="setFilter('category','Sanitary')">Sanitary Supplies</li>
                </ul>
            </div>
        </div>
        <div class="dropdown" onmouseleave="hideMenu('priceMenu')">
            <button class="drop-btn" onclick="toggleMenu('priceMenu')">Price ▾</button>
            <div class="menu" id="priceMenu">
                <ul>
                    <li onclick="setFilter('price','all')">All</li>
                    <li onclick="setFilter('price','0-5')">$0 - $5</li>
                    <li onclick="setFilter('price','5-10')">$5 - $10</li>
                    <li onclick="setFilter('price','10-20')">$10 - $20</li>
                    <li onclick="setFilter('price','20-999')">$20+</li>
                </ul>
            </div>
        </div>
        <div class="ml-auto">
            <select class="sort-select" id="sortSelect" onchange="handleSort()">
                <option value="default">Default Sorting</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name-az">Name: A-Z</option>
                <option value="name-za">Name: Z-A</option>
            </select>
        </div>
    </div>

    <div class="container">
        <div class="grid" id="productsGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>

    <div class="modal product-modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Product Details</h2>
                <button class="close-btn" onclick="closeProductModal()">×</button>
            </div>
            <div id="productDetails"></div>
        </div>
    </div>
    <!-- Para ma-trigger yung condition sa header pre na log in modal  -->
    <?php include '../includes/login-modal.php';?>
    <div class="toast" id="toast"></div>

    <script>
        let products = [];
        // let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let filters = { category: 'all', price: 'all' };
        let sortMethod = 'default';
        let currentPage = 1;
        const pageSize = 12;

        function renderProducts() {
            const grid = document.getElementById('productsGrid');

            grid.innerHTML = `
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <span>Loading products...</span>
                </div>
            `;

            setTimeout(() => {
                let filteredProducts = products.slice();

                if (filters.category !== 'all') filteredProducts = filteredProducts.filter(p => p.category === filters.category);
                if (filters.price !== 'all') {
                    const [minS, maxS] = filters.price.split('-');
                    const min = parseFloat(minS);
                    const max = parseFloat(maxS);
                    filteredProducts = filteredProducts.filter(p => p.price >= min && p.price <= (isNaN(max) ? Infinity : max));
                }

                if (sortMethod === 'price-low') {
                    filteredProducts.sort((a, b) => a.price - b.price);
                } else if (sortMethod === 'price-high') {
                    filteredProducts.sort((a, b) => b.price - a.price);
                } else if (sortMethod === 'name-az') {
                    filteredProducts.sort((a, b) => a.title.localeCompare(b.title));
                } else if (sortMethod === 'name-za') {
                    filteredProducts.sort((a, b) => b.title.localeCompare(a.title));
                }

                if (filteredProducts.length === 0) {
                    grid.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon">🔍</div>
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filters</p>
                        </div>
                    `;
                    return;
                }

                const totalPages = Math.max(1, Math.ceil(filteredProducts.length / pageSize));
                if (currentPage > totalPages) currentPage = totalPages;
                const start = (currentPage - 1) * pageSize;
                const pageProducts = filteredProducts.slice(start, start + pageSize);

                grid.innerHTML = pageProducts.map(product => {
                    return `
                        <div class="card" data-category="${product.category}" onmousemove="handleMouseMove(event, this)">
                            <div class="shine-overlay"></div>
                            <div class="image-container">
                                <img src="${product.image}" alt="Product Image">
                            </div>
                            <div class="card-content">
                                <span class="category-badge">${product.category}</span>
                                <h3 class="card-title">${product.title}</h3>
                                <p class="card-description">${product.description}</p>
                                <div class="card-footer">
                                    <div class="price-row">
                                        <span class="price">$${product.price}</span>
                                    </div>
                                    <div class="card-actions">
                                        <button class="view-more-btn" onclick="viewProduct(${product.id})">View More</button>
                                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                const pagEl = document.getElementById('pagination');
                const pages = [];
                for (let p = 1; p <= totalPages; p++) {
                    pages.push(`<button class="page-btn ${p===currentPage?'active':''}" onclick="gotoPage(${p})">${p}</button>`);
                }
                pagEl.innerHTML = pages.join('');
            }, 300);
        }

        console.log(products[0]);

        function viewProduct(product_id) {
            const product = products.find(p => p.id === product_id);

            const detailsHTML = `
                <div class="product-details">
                    <div class="product-header">
                        <div class="product-icon-large">
                            <img src="${product.image}" alt="${product.title}">
                        </div>
                        <div class="product-info">
                            <h3>${product.title}</h3>
                            <span class="category-badge">${product.category}</span>
                            <div class="product-price-large">$${product.price}</div>
                        </div>
                    </div>

                    <div class="product-description-full">
                        <h4 style="font-weight: 600; margin-bottom: 0.5rem;">About this product</h4>
                        <p>${product.description}. This premium ${product.category.toLowerCase()} product combines cutting-edge technology with elegant design to deliver an exceptional user experience. Perfect for both professionals and enthusiasts alike.</p>
                    </div>

                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart(${product.id}); closeProductModal()">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;

            document.getElementById('productDetails').innerHTML = detailsHTML;
            document.getElementById('productModal').classList.add('active');
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.remove('active');
        }

        function handleMouseMove(e, card) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const shineOverlay = card.querySelector('.shine-overlay');
            shineOverlay.style.background = `radial-gradient(circle 150px at ${x}px ${y}px, rgba(255, 255, 255, 0.8), transparent 80%)`;
        }

        function handleSort() {
            sortMethod = document.getElementById('sortSelect').value;
            renderProducts();
        }

        function setFilter(key, value) {
            filters[key] = value;
            currentPage = 1;
            renderProducts();
            hideAllMenus();
        }

        function gotoPage(p) {
            currentPage = p;
            renderProducts();
            window.scrollTo({top:0, behavior:'smooth'});
        }

        function toggleMenu(id){
            const el=document.getElementById(id);
            el.classList.toggle('show');
        }

        function hideMenu(id){
            const el=document.getElementById(id);
            el.classList.remove('show');
        }

        function hideAllMenus(){
            ['catMenu','priceMenu'].forEach(hideMenu);
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }
        console.log("addToCart function is loaded into memory");

        // c convert to ajax
        function addToCart(product_id, quantity = 1) {
          console.log("addToCart triggered:", product_id);
        // intentionally break here for debug
        console.log("Sending request with:", product_id, quantity);
        // debugger;
          fetch('../ajax/add-to-cart.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: new URLSearchParams({ product_id: product_id, quantity: 1 })
          })
          .then(res => res.json())
          .then(data => {
            console.log("Response from server:", data);
              if (data.success) {
                  showToast(data.message ||'Added to cart');
                  fetchCart();
              } else {
                  showToast(data.message || 'Failed to add to cart');
              }
          })
          .catch(err => console.error(err));
      }

      // fetch ng cart counter
      function fetchCart() {
    fetch('../ajax/fetch-cart.php')
        .then(res => res.json())
        .then(data => {
            const cartCount = document.getElementById('cartCount');
            cartCount.textContent = data.count || 0;
        });
}
  // fetch ng removeFromCart
    function removeFromCart(product_id) {
        fetch('../ajax/remove-from-cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ product_id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Item removed');
                fetchCart();
            } else {
                showToast(data.message || 'Failed to remove item');
            }
        })
        .catch(err => console.error(err));
    }
      function updateQuantity(product_id, delta) {
      fetch('../ajax/update-cart.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ product_id, delta })
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              fetchCart();
          } else {
              showToast(data.message || 'Update failed');
          }
      })
      .catch(err => console.error(err));
  }

  function clearCart() {
    if (!confirm('Clear all items from cart?')) return;
    fetch('../ajax/clear-cart.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Cart cleared');
                fetchCart();
            } else {
                showToast('Failed to clear cart');
            }
        });
}
function showCartPreview() {
    fetch('../ajax/fetch-cart.php')
        .then(res => res.json())
        .then(data => {
            const list = document.getElementById('cartPreviewList');
            list.innerHTML = data.cart.map(item => `
                <div class="cart-item">
                    <img src="../${item.product_image}" width="40">
                    <span>${item.product_name}</span>
                    <span>x${item.quantity}</span>
                </div>
            `).join('');
        });
}

        // c convert to ajax
        // function removeFromCart(product_id) {
        //     const product = products.find(p => p.id === product_id);
        //     cart = cart.filter(item => item.id !== product_id);
        //     showToast(`${product.title} removed from cart`);
        //     updateCart();
        // }
        // c convert to ajax
        // function updateQuantity(product_id, delta) {
        //     const item = cart.find(item => item.id === product_id);
        //     if (item) {
        //         item.quantity += delta;
        //         if (item.quantity <= 0) {
        //             removeFromCart(productId);
        //         } else {
        //             updateCart();
        //         }
        //     }
        // }
        // c convert to ajax
        // function clearCart() {
        //     if (cart.length === 0) return;
        //
        //     if (confirm('Are you sure you want to clear your cart?')) {
        //         cart = [];
        //         updateCart();
        //         showToast('Cart cleared');
        //     }
        // }
        // c convert to ajax
        // function updateCart() {
        //     const cartCount = document.getElementById('cartCount');
        //     localStorage.setItem('cart', JSON.stringify(cart));
        //
        //     const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        //     cartCount.textContent = totalItems;
        // }

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        function fetchProducts() {
            const params = new URLSearchParams();
            params.set('page', currentPage);
            params.set('pageSize', pageSize);
            params.set('sort', sortMethod);
            if (filters.category !== 'all') {
                const catMap = { 'School Supplies': 'school-supplies', 'Office Supplies': 'office-supplies', 'Sanitary': 'sanitary' };
                params.set('category', catMap[filters.category] || filters.category);
            }

            return fetch('../api/products.php?' + params.toString())
                .then(r => r.json())
                .then(data => {
                    products = data.items || [];
                    renderProducts();
                })
                .catch(() => {
                    products = [];
                    renderProducts();
                });
        }

        fetchProducts();
        fetchCart();
    </script>
    <script src="../assets/js/homepage.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
