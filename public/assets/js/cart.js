document.addEventListener('DOMContentLoaded', function() {
    const qtyInputs = document.querySelectorAll('.qty-input');

    qtyInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const productId = this.dataset.id;
            const newQty = parseInt(this.value);
            const tr = this.closest('tr');

            if (newQty < 1) {
                this.value = 1;
                return;
            }

            // Kirim update ke Laravel (Controller)
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ qty: newQty })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update Subtotal baris ini
                    const subtotalCell = tr.querySelector('.subtotal-cell');
                    subtotalCell.textContent = 'Rp' + data.itemSubtotal.toLocaleString('id-ID');

                    // Update Grand Total di bawah
                    const totalCell = document.querySelector('.cart-total-price');
                    if (totalCell) {
                        totalCell.textContent = 'Rp' + data.total.toLocaleString('id-ID');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});