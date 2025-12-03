document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const productId = params.get('id');

    if (!productId) {
        alert("No product selected");
        return;
    }

    fetch(`get_product.php?id=${productId}`)
        .then(res => {
            if (!res.ok) throw new Error(`Network error: ${res.status}`);
            return res.json();
        })
        .then(product => {

            if (product.error) {
                alert(product.error);
                return;
            }

            const imgEl = document.getElementById('pd-img');
            const nameEl = document.getElementById('pd-name');
            const descEl = document.getElementById('pd-desc');
            const priceEl = document.getElementById('pd-price');

            if (imgEl) imgEl.src = product.primary_image || '';
            if (nameEl) nameEl.textContent = product.name || 'No name';
            if (descEl) descEl.textContent = product.description || 'No description';
            if (priceEl) priceEl.textContent = product.price ? `$${product.price}` : 'Price unavailable';

            const buyBtn = document.getElementById("btn-buy-confirm");
            if (buyBtn) {
                buyBtn.addEventListener("click", () => {
                    const confirmBuy = confirm("Are you sure you want to buy this product?");
                    if (confirmBuy) {
                        alert("Payment Successful! Redirecting to checkout.");
                    }
                });
            }

            const addBtn = document.getElementById('btn-add-cart');
            if (addBtn) {
                addBtn.addEventListener('click', () => {
                    fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `product_id=${productId}&quantity=1`
                    })
                    .then(res => {
                        if (!res.ok) throw new Error(`Network error: ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Product added to cart!');
                            window.location.href = "cart.html";
                        } else {
                            alert('Error adding product to cart.');
                        }
                    })
                    .catch(err => console.error('Error adding to cart:', err));
                });
            }

        })
        .catch(err => console.error('Error loading product:', err));
});
