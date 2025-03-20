<x-table-layout title="Product Sales in Last 30 Days">
    <div class="container mt-4">
        <h1>Product Sales in Last 30 Days</h1>
        <table class="table table-bordered" id="salesTable">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Total Quantity Sold</th>
                </tr>
            </thead>
        </table>
    </div>


</x-table-layout>
<script>
    $(document).ready(function() {
        $('#salesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reports.product_sales_last_30_days') }}",
            columns: [{
                    data: 'product_id',
                    name: 'product_id'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'total_quantity_sold',
                    name: 'total_quantity_sold'
                }
            ],

        });
    });
</script>
