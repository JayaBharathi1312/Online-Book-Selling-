document.addEventListener('DOMContentLoaded', () => {
    let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cartItems');
    const grandTotalElement = document.getElementById('grandTotal');

    function calculateTotal(price, quantity) { 
        return (price * quantity).toFixed(2);
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        cartItems.forEach(item => {
            grandTotal += item.price * item.quantity;
        });
        grandTotalElement.textContent = grandTotal.toFixed(2);
    }

    function removeItem(index) {
        cartItems.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cartItems));
        renderCartItems();
    }

    function renderCartItems() {
        cartItemsContainer.innerHTML = '';
        cartItems.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${item.image}" alt="Book Image"></td>
                <td>${item.name}</td>
                <td>${item.price.toFixed(2)}</td>
                <td><input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input"></td>
                <td>&#8377;<span class="item-total">${calculateTotal(item.price, item.quantity)}</span></td>
                <td><button class="remove-button" data-index="${index}">Remove</button></td>
            `;
            cartItemsContainer.appendChild(row);
        });
        updateGrandTotal();
    }

    cartItemsContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-button')) {
            const index = event.target.getAttribute('data-index');
            removeItem(index);
        }
    });

    cartItemsContainer.addEventListener('change', (event) => {
        if (event.target.classList.contains('quantity-input')) {
            const index = event.target.getAttribute('data-index');
            const newQuantity = parseInt(event.target.value, 10);
            cartItems[index].quantity = newQuantity;
            localStorage.setItem('cart', JSON.stringify(cartItems));
            renderCartItems();
        }
    });

    document.getElementById('proceedButton').addEventListener('click', () => {
        if (cartItems.length === 0) {
            alert('Your cart is empty!');
        } else {
            alert('Proceeding to checkout...');
        }
    });

    renderCartItems();
});
