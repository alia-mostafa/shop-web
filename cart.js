document.addEventListener("DOMContentLoaded", function () {
    const cartContainer = document.getElementById('cart-container');
    const cartSummaryElement = document.getElementById('cart-summary'); 
    const deleteAllBtn = document.getElementById('btn-delete-all');
    
    function loadCart() {
        cartContainer.innerHTML = '<div>Loading cart items...</div>';
        
        fetch('get_cart.php') 
            .then(res => res.json())
            .then(data => {
                cartContainer.innerHTML = ''; 
                let grandTotal = 0;

                if (data.success && data.items.length > 0) {
                    
                    data.items.forEach(item => {
                         
                        const productCard = document.createElement('div');
                        productCard.classList.add('product-cart-card'); 
                        productCard.dataset.cartId = item.cart_id;

                        productCard.innerHTML = `
                            <div class="card-content">
                                <img src="${item.image_url || 'images/placeholder.jpg'}" alt="${item.name}" class="product-image" />
                                <div class="product-details">
                                    <h3>${item.name}</h3>
                                    <p class="price-info">$${item.price.toFixed(2)}</p>
                                    <p class="quantity-info">Quantity: ${item.quantity}</p>
                                    <button class="btn-remove" data-id="${item.cart_id}">Delete</button>
                                </div>
                            </div>
                            `;
                        cartContainer.appendChild(productCard);
                    });

                    cartSummaryElement.innerHTML = `
                        `;
                    deleteAllBtn.style.display = 'block'; 

                } else {
                    cartContainer.innerHTML = '<div class="empty-cart-message">Your cart is empty.</div>';
                    cartSummaryElement.innerHTML = '';
                    deleteAllBtn.style.display = 'none'; 
                }
            })
            .catch(err => {
                console.error('Error fetching cart data:', err);
            
                cartContainer.innerHTML = '<div class="error-message">Could not load cart data due to a server error.</div>';
            });
    }

    function removeItem(cartId) {
        if (!confirm("Are you sure you want to remove this item?")) return;

        fetch('delete_item.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `cart_id=${cartId}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Item removed!");
                loadCart();
            } else {
                alert("Error removing item.");
            }
        })
        .catch(err => console.error('Error:', err));
    }

    if (deleteAllBtn) {
    deleteAllBtn.addEventListener('click', () => {
        if (confirm("Are you sure you want to clear your entire cart?")) {

            fetch('delet_all.php', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Cart cleared successfully!");
                    loadCart();
                } else {
                    alert("Error clearing cart.");
                }
            })
            .catch(err => console.error('Error clearing cart:', err));
        }
    });
}


    cartContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove')) {
            const cartId = e.target.getAttribute('data-id');
            if (cartId) {
                removeItem(cartId);
            }
        }
    });
    loadCart();
});