<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class OrderItemController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'admin'],),
        ];
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orderitems = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select([
                    'order_items.id',
                    'orders.id as order_id',
                    'products.name as product_name',
                    'order_items.quantity',
                    'order_items.price_at_purchase',
                    'order_items.created_at',
                    'order_items.updated_at'
                ]);

            return DataTables::of($orderitems)
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->whereRaw('LOWER(products.name) LIKE ?', ["%" . strtolower($keyword) . "%"]);
                })
                ->editColumn('price_at_purchase', function ($orderitem) {
                    return number_format($orderitem->price_at_purchase, 2) . ' $';
                })
                ->addColumn('action', function ($orderitem) {
                    return '
                      <div class="d-flex justify-content-between">
                        <a href="' . route('orderitems.edit', $orderitem->id) . '" class="btn btn-info btn-sm">Edit</a>
                        
                        <form action="' . route('orderitems.destroy', $orderitem->id) . '" method="POST" class="delete-form">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </div>';
                })
                ->editColumn('created_at', function ($orderitem) {
                    return $orderitem->created_at->format('Y-m-d H:i');
                })
                ->editColumn('updated_at', function ($orderitem) {
                    return $orderitem->updated_at->format('Y-m-d H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('orderitems.index');
    }


    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('orderitems.create', ['orders' => $orders, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price_at_purchase' => 'required|numeric|min:0',
        ]);

        OrderItem::create($request->all());

        return redirect()->route('orderitems.index')->with('success', 'Order item created successfully!');
    }

    public function edit(OrderItem $orderitem)
    {
        $orders = Order::all();
        $products = Product::all();
        return view('orderitems.edit', ['orders' => $orders, 'orderitem' => $orderitem, 'products' => $products]);
    }

    public function update(Request $request, OrderItem $orderitem)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price_at_purchase' => 'required|numeric|min:0',
        ]);

        $orderitem->update($request->all());

        return redirect()->route('orderitems.index')->with('success', 'Order item updated successfully!');
    }

    public function destroy(OrderItem $orderitem)
    {
        $orderitem->delete();
        return back()->with('delete', 'Order item deleted successfully!');
    }
}
