<x-table-layout title="Orders with More Than 3 Different Products">
    <div class="container mt-4">
        <h1>Orders with More Than 3 Different Products</h1>
        <table class="table table-bordered" id="ordersWithManyProductsTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Distinct Products</th>

                </tr>
            </thead>
        </table>
    </div>




</x-table-layout>
<script>
    $(document).ready(function() {
        $('#ordersWithManyProductsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reports.orders_with_more_than_3_products') }}",
            columns: [{
                    data: 'order_id',
                    name: 'order_id'
                },
                {
                    data: 'distinct_products',
                    name: 'distinct_products'
                }


            ]
        });
    });
</script>
