<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

class ReportController extends Controller
{
public function ordersLast7Days(Request $request)
{
    if ($request->ajax()) {
        $orders = Order::select([
                'orders.id',
                'users.name as customer_name',
                'orders.total_price',
                'orders.created_at'
            ])
            ->join('users', 'orders.user_id', '=', 'users.id') 
            ->where('orders.created_at', '>=', now()->subDays(7))
            ->orderBy('orders.created_at', 'desc');

        return DataTables::of($orders)
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d H:i');
            })
            
            ->filterColumn('customer_name', function($query, $keyword) {
                $query->where('users.name', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    return view('reports.orders_last_7_days');
}


public function productSalesLast30Days(Request $request)
{
    if ($request->ajax()) {
        $sales = OrderItem::selectRaw('
                products.id as product_id, 
                products.name as product_name, 
                SUM(order_items.quantity) as total_quantity_sold
            ')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity_sold', 'desc');

        return DataTables::of($sales)
            ->filterColumn('product_name', function ($query, $keyword) {
                $query->whereRaw('LOWER(products.name) LIKE ?', ["%" . strtolower($keyword) . "%"]);
            })
            ->filterColumn('total_quantity_sold', function ($query, $keyword) {
                $query->havingRaw('SUM(order_items.quantity) LIKE ?', ["%{$keyword}%"]);
            })
            ->orderColumn('total_quantity_sold', function ($query, $order) {
                $query->orderByRaw('SUM(order_items.quantity) ' . $order);
            })
            ->make(true);
    }

    return view('reports.product_sales_last_30_days');
}



public function top5Customers(Request $request)
{
    if ($request->ajax()) {
        $topCustomers = User::selectRaw('
                users.id as customer_id, 
                users.name as customer_name, 
                SUM(orders.total_price) as total_spent
            ')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->limit(5);

        return DataTables::of($topCustomers)
        ->filterColumn('customer_id', function ($query, $keyword) {
            $query->where('users.id', 'like', "%" . $keyword . "%");
        })
            // Filter for the customer name using users.name
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereRaw('LOWER(users.name) LIKE ?', ["%" . strtolower($keyword) . "%"]);
            })
            // Filter for the total spent using SUM(orders.total_price)
            ->filterColumn('total_spent', function ($query, $keyword) {
                $query->havingRaw('SUM(orders.total_price) LIKE ?', ["%{$keyword}%"]);
            })
            // Make sure the sorting works for the total_spent column
            ->orderColumn('total_spent', function ($query, $order) {
                $query->orderByRaw('SUM(orders.total_price) ' . $order);
            })
            ->make(true);
    }

    return view('reports.top_5_customers');
}



public function ordersWithMoreThan3Products(Request $request)
{
    if ($request->ajax()) {
        $orders = Order::selectRaw('orders.id as order_id, COUNT(DISTINCT order_items.product_id) as distinct_products')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('orders.id')
            ->having('distinct_products', '>', 3);

        // Add search filters for order_id and distinct_products
        return DataTables::of($orders)
            ->filterColumn('order_id', function ($query, $keyword) {
                $query->where('orders.id', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('distinct_products', function ($query, $keyword) {
                $query->havingRaw('COUNT(DISTINCT order_items.product_id) LIKE ?', ["%{$keyword}%"]);
            })
            ->make(true);
    }

    return view('reports.orders_with_more_than_3_products');
}



// public function orderProductsList(Request $request)
// {
//     if ($request->ajax()) {
//         $orders = Order::selectRaw('
//                 orders.id as order_id, 
//                 GROUP_CONCAT(products.name SEPARATOR ", ") as products
//             ')
//             ->join('order_items', 'orders.id', '=', 'order_items.order_id')
//             ->join('products', 'order_items.product_id', '=', 'products.id')
//             ->groupBy('orders.id');

//         return DataTables::of($orders)
//             ->filterColumn('order_id', function ($query, $keyword) {
//                 $query->where('orders.id', 'like', "%" . $keyword . "%");
//             })
//             // Adjust the search for products using havingRaw for aggregation
//             ->filterColumn('products', function ($query, $keyword) {
//                 $query->havingRaw('GROUP_CONCAT(products.name SEPARATOR ", ") LIKE ?', ["%{$keyword}%"]);

//             })


            
//             ->make(true);
//     }

//     return view('reports.order_products_list');
// }

public function orderProductsList(Request $request)
{
    if ($request->ajax()) {
        $orders = Order::selectRaw('
                orders.id as order_id, 
                GROUP_CONCAT(CONCAT(products.name, " (", order_items.quantity, ")") SEPARATOR ", ") as products
            ')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('orders.id');

        return DataTables::of($orders)
            ->filterColumn('order_id', function ($query, $keyword) {
                $query->where('orders.id', 'like', "%" . $keyword . "%");
            })
            // Adjust the search for products using havingRaw for aggregation
            ->filterColumn('products', function ($query, $keyword) {
                $query->havingRaw('GROUP_CONCAT(CONCAT(products.name, " (", order_items.quantity, ")") SEPARATOR ", ") LIKE ?', ["%{$keyword}%"]);
            })
            ->make(true);
    }

    return view('reports.order_products_list');
}


}
