<x-table-layout title="Order List">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Orders List</h2>
        </div>
        <table class="table table-bordered" id="orders-table">
            <thead>
                <tr>
                    <th>Order ID </th>
                    <th>Username</th>
                    <th> ProductNames(QTY)</th>
                    <th>Total Price</th>
                    <th>Order Created_at </th>
                </tr>
            </thead>
        </table>
    </div>


</x-table-layout>

<script>
    $(document).ready(function() {
        var table = $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'products',
                    name: 'products'
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
    });
</script>
