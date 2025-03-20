<x-table-layout title="Products Purchased Per Order">
    <div class="container mt-4">
        <h1>Products Purchased Per Order</h1>
        <table class="table table-bordered" id="orderProductsTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Products(QTY)</th>
                </tr>
            </thead>
        </table>
    </div>




</x-table-layout>
<script>
    $(document).ready(function() {
        $('#orderProductsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reports.order_products_list') }}",
            columns: [{
                    data: 'order_id',
                    name: 'order_id'
                },
                {
                    data: 'products',
                    name: 'products'
                }
            ]
        });
    });
</script>
