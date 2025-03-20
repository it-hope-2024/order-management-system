<x-table-layout title="Orders ">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Orders </h1>
            <a href="{{ route('orders.create') }}" class="btn btn-success">Create Order</a>
        </div>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Created At</th>
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
            ajax: "{{ route('orders.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
