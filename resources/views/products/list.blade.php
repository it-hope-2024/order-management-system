{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 11 Yajra Datatables Tutorial - ItSolutionStuff.com</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    @vite(['resources/js/app.js'])
</head> --}}

<x-table-layout title="Product List">
    
    <div class="container mt-4">
        <h1>Product List</h1>
    
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
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.list') }}",
            columns: [
                {data: 'id', name: 'id'},
                // {data: 'name', name: 'name', title: 'Name'},
                {data: 'name_en', name: 'name_en',orderable: true },
                {data: 'name_ar', name: 'name_ar',orderable: true},
                {data: 'price', name: 'price'},
                {data: 'stock', name: 'stock'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    //SWAL Func
    $(document).on("click", ".delete-btn", function (e) {
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
    $(document).ready(function () {
        // Check if session delete message exists
        @if(session('delete'))
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
</script>


{{-- </html> --}}