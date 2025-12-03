document.addEventListener("DOMContentLoaded", function () {
    fetch('product.php')
        .then(response => response.json())
        .then(products => {
            const grid = document.getElementById('products-grid');

            products.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product-card';

                card.innerHTML = `
                    <img src="${product.primary_image}" 
                         alt="${product.name}" 
                         class="product-image" />
                    <div class="product-details">
                        <h2 class="product-name">${product.name}</h2>
                        <p class="product-description">${product.description}</p>
                        <div class="product-price">$${product.price}</div>
                        <a href="buy_now.html?id=${product.product_id}" class="btn-buy">Buy Now</a>
                    </div>
                `;

                grid.appendChild(card);
            });
        })
        .catch(err => console.error('Error loading products:', err));
});