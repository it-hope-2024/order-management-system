<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'No Title' }}</title>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark  ">
        <div class="container">
            <a class="navbar-brand" href="{{ route('management') }}">Order System Management</a>

            <!-- Navbar Toggler for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.list') }}">
                            Orders List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('orders.index') }}">
                            Orders (CRUD)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.list') }}">
                            Products (CRUD)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('orderitems.index') }}">
                            Order Items (CRUD)
                        </a>
                    </li>
                    <!-- Dropdown for Reports -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Reports
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                            <li><a class="dropdown-item" href="{{ route('reports.orders_last_7_days') }}">Orders Last 7
                                    Days</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('reports.product_sales_last_30_days') }}">Product Sales Last 30
                                    Days</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.top_5_customers') }}">Top 5
                                    Customers</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('reports.orders_with_more_than_3_products') }}">Orders With 3+
                                    Products</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.order_products_list') }}">Products Per
                                    Order</a></li>
                        </ul>
                    </li>

                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button
                                    class="nav-link btn btn-danger text-white px-3 py-2 rounded shadow-sm d-flex align-items-center gap-2"
                                    style="border: none; transition: 0.3s;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" x2="9" y1="12" y2="12" />
                                    </svg>
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{ $slot }}

</body>



</html>
