<x-table-layout title="Product List">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Product List</h1>
            <a href="{{ route('products.create') }}" class="btn btn-success">Create Product</a>
        </div>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name En</th>
                    <th>Name Ar</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

</x-table-layout>


<script type="text/javascript">
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name_en',
                    name: 'name_en',
                    orderable: true
                },
                {
                    data: 'name_ar',
                    name: 'name_ar',
                    orderable: true
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
    //SWAL Func
    $(document).on("click", ".delete-btn", function(e) {
        e.preventDefault(); // Prevent default form submission

        var form = $(this).closest("form"); // Get the closest form element

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });

    // Show SweetAlert Toast if a success message exists in session
    $(document).ready(function() {
        // Check if session delete message exists
        @if (session('delete'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: "{{ session('delete') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    });


    document.addEventListener("DOMContentLoaded", function() {
        // Check if success message is stored in sessionStorage
        let successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: successMessage,
                showConfirmButton: false,
                timer: 3000
            });
            sessionStorage.removeItem('successMessage'); // Clear message after displaying
        }
    });

    // Before redirecting, store success message
    @if (session('success'))
        sessionStorage.setItem('successMessage', "{{ session('success') }}");
    @endif
</script>
