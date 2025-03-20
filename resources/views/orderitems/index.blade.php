<x-table-layout title="Order Items">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Order Items</h1>
            <a href="{{ route('orderitems.create') }}" class="btn btn-success">Create Order Item</a>
        </div>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price at Purchase</th>
                    <th>Created At</th>
                    <th>Updated At</th>
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
            ajax: "{{ route('orderitems.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'order_id',
                    name: 'order_id'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'price_at_purchase',
                    name: 'price_at_purchase'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
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

    // DELETE WITH SWAL
    $(document).on("click", ".delete-btn", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");
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
                form.submit();
            }
        });
    });

    // SWEET ALERT SUCCESS MESSAGE
    $(document).ready(function() {
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
            sessionStorage.removeItem('successMessage');
        }
    });

    @if (session('success'))
        sessionStorage.setItem('successMessage', "{{ session('success') }}");
    @endif
</script>
