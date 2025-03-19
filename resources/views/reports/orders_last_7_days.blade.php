<x-table-layout title="Orders Created in Last 7 Days">
    <div class="container mt-4">
        <h1>Orders Created in Last 7 Days</h1>
        <table class="table table-bordered" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                </tr>
            </thead>
        </table>
    </div>




</x-table-layout>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reports.orders_last_7_days') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'total_price', name: 'total_price' },
                { data: 'created_at', name: 'created_at' }
            ]
        });
    });
</script>