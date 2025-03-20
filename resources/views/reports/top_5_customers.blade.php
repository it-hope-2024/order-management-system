<x-table-layout title="Top 5 Customers by Spending">
    <div class="container mt-4">
        <h1>Top 5 Customers by Spending</h1>
        <table class="table table-bordered" id="topCustomersTable">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
        </table>
    </div>



</x-table-layout>
<script>
    $(document).ready(function() {
        $('#topCustomersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reports.top_5_customers') }}",
            columns: [{
                    data: 'customer_id',
                    name: 'customer_id'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'total_spent',
                    name: 'total_spent'
                }
            ]
        });
    });
</script>
