<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ env('APP_NAME') }}</title>
   
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

    




// function addToCart(productId) {
//     console.log("Adding product to cart...");

//     // Sending a POST request to add the product to the cart
//     fetch(`/orders/add-to-cart/${productId}`, {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,  // CSRF Token for security
//             'Content-Type': 'application/json'  // Set the content type as JSON
//         },
//         body: JSON.stringify({
//             // You can send more data if needed, such as quantity or additional product details
//             productId: productId
//         })
//     })
//     .then(response => response.json())  // Parse the JSON response
//     .then(data => {
//         // Check if the response was successful
//         if (data.success) {
//             // Update the cart count (you can adjust this based on your page structure)
//             document.getElementById('cart-count').innerText = data.cartCount;
//             Swal.fire('تمت الإضافة!', 'تمت إضافة المنتج إلى طلباتك.', 'success');  // Show success message
//         } else {
//             Swal.fire('خطأ!', data.message, 'error');  // Show error message if something went wrong
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);  // Log any errors that occur
//         Swal.fire('خطأ!', 'حدث خطأ غير متوقع.', 'error');  // Show a generic error message
//     });
// }
function addToCart(productId) {
    fetch(`/orders/add-to-cart/${productId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({}),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("cart-count").innerText = data.cartCount;
            document.getElementById(`product-stock-${productId}`).innerText = data.newStock;

            if (data.newStock == 0) {
                let stockElement = document.getElementById(`product-stock-${productId}`);
                stockElement.classList.remove("text-green-600");
                stockElement.classList.add("text-red-600");
                stockElement.innerText = "نفد من المخزون";

                let addButton = document.getElementById(`add-to-cart-btn-${productId}`);
                if (addButton) addButton.remove();
            }

            Swal.fire({
                icon: "success",
                title: "تمت الإضافة",
                text: "تمت إضافة المنتج إلى السلة!",
                timer: 1500,
                showConfirmButton: false,
            });
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            icon: "error",
            title: "خطأ!",
            text: "حدث خطأ غير متوقع.",
        });
    });
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
            Swal.fire('تم الحذف!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('خطأ!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
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
            Swal.fire('تم التأكيد!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('خطأ!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}





</script>