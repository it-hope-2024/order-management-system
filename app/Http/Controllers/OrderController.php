<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DB;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'admin'], only: ['index', 'create', 'store', 'update', 'edit', 'destroy', 'getOrders']),
            new Middleware(['auth'],),

        ];
    }

    public function addToCart($productId, Request $request)

    {

        try {
            $product = Product::findOrFail($productId);

            $quantity = $request->input('quantity', 1);

            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available.'
                ], 400);
            }

            $order = Auth::user()->orders()->where('status', 'pending')->first();
            if (!$order) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'total_price' => 0,
                ]);
            }

            $orderItem = $order->orderItems()->where('product_id', $product->id)->first();

            if ($orderItem) {
                $orderItem->increment('quantity', $quantity);
            } else {
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price_at_purchase' => $product->price,
                ]);
            }

            $product->decrement('stock', $quantity);

            $order->update([
                'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'cartCount' => $order->orderItems()->sum('quantity'),
                'newStock' => $product->fresh()->stock,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function confirmOrder()
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'pending')->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'There Is No Pending Orders To Confirm']);
        }

        $order->update(['status' => 'completed']);

        return response()->json(['success' => true, 'message' => 'Order has Been Confirmed Successfully', 'cartCount' => 0]);
    }


    public function removeItem($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $order = $orderItem->order;

            $orderItem->product->increment('stock', $orderItem->quantity);

            $orderItem->delete();

            if ($order->orderItems()->count() === 0) {
                $order->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted as it became empty!',
                    'cartCount' => 0,
                    'totalPrice' => 0
                ]);
            }

            $order->update([
                'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product removed successfully!',
                'cartCount' => $order->orderItems()->sum('quantity'),
                'totalPrice' => $order->total_price,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the item.',
            ], 500);
        }
    }

    public function decreaseItem($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $order = $orderItem->order;

            if ($orderItem->quantity > 1) {
                $orderItem->decrement('quantity');
                $orderItem->product->increment('stock');
            } else {
                $orderItem->product->increment('stock', $orderItem->quantity);
                $orderItem->delete();
            }

            if ($order->orderItems()->count() === 0) {
                $order->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted as it became empty!',
                    'cartCount' => 0,
                ]);
            }

            $order->update([
                'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantity decreased successfully!',
                'cartCount' => $order->orderItems()->sum('quantity'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while decreasing the item quantity.',
            ], 500);
        }
    }



    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('orderItems.product')
            ->get();

        return view('orders.my-orders',  ['orders' => $orders]);
    }


    public function myPurchases()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('orderItems.product')
            ->get();

        $totalOrdersPrice = $orders->sum('total_price');
        return view('orders.my-purchases',  ['orders' => $orders, 'totalOrdersPrice' => $totalOrdersPrice]);
    }


    public function getOrders(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('orderItems.product')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(['orders.*', 'users.name as user_name']);

            return DataTables::of($orders)
                ->addColumn('products', function ($order) {
                    return $order->orderItems
                        ->groupBy('product_id')
                        ->map(fn($items) => $items->first()->product->name . ' (' . $items->sum('quantity') . ')')
                        ->implode(', ');
                })
                ->editColumn('total_price', fn($order) => number_format($order->total_price, 2) . ' $')
                ->editColumn('created_at', fn($order) => $order->created_at->format('Y-m-d H:i'))
                ->filterColumn('user_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', "%$keyword%");
                })
                ->make(true);
        }

        return view('orders.list');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('user')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select([
                    'orders.id',
                    'orders.user_id',
                    'users.name as user_name',
                    'orders.total_price',
                    'orders.status',
                    'orders.created_at'
                ]);

            return DataTables::of($orders)
                ->filterColumn('user_name', function ($query, $keyword) {
                    $query->whereRaw("LOWER(users.name) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                })

                ->editColumn('total_price', function ($order) {
                    return number_format($order->total_price, 2) . ' $';
                })
                ->editColumn('status', function ($order) {
                    return $order->status === 'pending'
                        ? '<span class="badge bg-warning">Pending</span>'
                        : '<span class="badge bg-success">Completed</span>';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('Y-m-d H:i');
                })
                ->addColumn('action', function ($order) {
                    return '
                      <div class="d-flex justify-content-between">
                        <a href="' . route('orders.edit', $order->id) . '" class="btn btn-info btn-sm">Edit</a>
                        
                        <form action="' . route('orders.destroy', $order->id) . '" method="POST" class="delete-form">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('orders.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Fetch all users
        return view('orders.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,completed',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total_price' => $request->input('total_price'),
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $users = User::all();
        return view('orders.edit', ['order' => $order, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,completed',
        ]);

        $order->update([
            'user_id' => $request->user_id,
            'total_price' => $request->input('total_price'),
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('delete', 'Your Order was deleted!');
    }
}
