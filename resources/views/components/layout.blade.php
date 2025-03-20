<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body >
<x-navbar></x-navbar>

     
    {{{$slot }}}


  <x-footer></x-footer>
</body>
</html>
 
<script>
function increaseQuantity(productId, maxStock) {
    let qtyInput = document.getElementById(`quantity-${productId}`);
    let currentQty = parseInt(qtyInput.value);
    if (currentQty < maxStock) {
        qtyInput.value = currentQty + 1;
    }
}

function decreaseQuantity(productId) {
    let qtyInput = document.getElementById(`quantity-${productId}`);
    let currentQty = parseInt(qtyInput.value);
    if (currentQty > 1) {
        qtyInput.value = currentQty - 1;
    }
}

function addToCart(productId) {
    let quantity = parseInt(document.getElementById(`quantity-${productId}`).value);

    fetch(`/orders/add-to-cart/${productId}`, {  
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: quantity })  
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire("Added to cart!", data.message, "success");
            document.getElementById("cart-count").innerText = data.cartCount;  
            document.getElementById(`product-stock-${productId}`).innerText = data.newStock;  

            if (data.newStock == 0) {
                let stockElement = document.getElementById(`product-stock-${productId}`);
                stockElement.classList.remove("text-green-600");
                stockElement.classList.add("text-red-600");
                stockElement.innerText = "Out of stock";

                let addButton = document.getElementById(`add-to-cart-btn-${productId}`);
                if (addButton) addButton.remove();
            }
        } else {
            Swal.fire("Oops!", data.message, "error");
        }
    })
    .catch(error => console.error("Fetch error:", error));
}
function updateCartCount(count) {
    document.getElementById("cart-count").innerText = count;
}
    

function confirmOrder() {
    fetch('/orders/confirm', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-count').innerText = 0;
            Swal.fire('Confirm Done!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}


function decreaseItem(itemId) {
    fetch(`/orders/decrease-item/${itemId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-count').innerText = data.cartCount;
            Swal.fire('Updated!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

function removeItem(itemId) {
    fetch(`/orders/remove-item/${itemId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-count').innerText = data.cartCount;
            Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

function showAuthAlert() {
    Swal.fire({
        title: "You're not logged in!",
        text: "Please login or register to add items to your cart.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Login",
        cancelButtonText: "Register",
        allowOutsideClick: false,
        showCloseButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/login";  // Redirect to login page
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = "/register";  // Redirect to register page
        }
    });
}



</script>