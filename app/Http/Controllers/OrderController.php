<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DB;
use App\Models\User;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{

    public function addToCart($productId, Request $request)

    {

        try {
            // جلب المنتج
            $product = Product::findOrFail($productId);

            // الحصول على الكمية المطلوبة من الطلب (أو افتراضيًا 1)
            $quantity = $request->input('quantity', 1);

            // التحقق من توفر المخزون
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available.'
                ], 400);
            }

            // البحث عن طلب المستخدم الحالي (المعلق)
            $order = Auth::user()->orders()->where('status', 'pending')->first();
            if (!$order) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'total_price' => 0,
                ]);
            }

            // البحث عن المنتج في الطلب الحالي (إن وجد)
            $orderItem = $order->orderItems()->where('product_id', $product->id)->first();

            if ($orderItem) {
                // إذا كان المنتج موجودًا، قم بتحديث الكمية فقط
                $orderItem->increment('quantity', $quantity);
            } else {
                // إذا لم يكن المنتج موجودًا، أضفه إلى الطلب
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price_at_purchase' => $product->price,
                ]);
            }

            // تقليل الكمية من المخزون
            $product->decrement('stock', $quantity);

            // تحديث إجمالي السعر للطلب
            $order->update([
                'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
            ]);

            // إرسال المخزون الجديد وعدد العناصر المحدث إلى الواجهة
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'cartCount' => $order->orderItems()->sum('quantity'),  // ✅ عدد جميع العناصر في السلة
                'newStock' => $product->fresh()->stock, // ✅ تحديث الكمية بعد التعديل
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

    // 🛍️ عرض الطلبات الحالية
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
    public function removeItem($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $order = $orderItem->order;

            // زيادة المخزون بالكميات المحذوفة
            $orderItem->product->increment('stock', $orderItem->quantity);

            // حذف العنصر من الطلب
            $orderItem->delete();

            // التحقق مما إذا كان الطلب فارغًا بعد الحذف
            if ($order->orderItems()->count() === 0) {
                $order->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted as it became empty!',
                    'cartCount' => 0, // لا يوجد عناصر في السلة
                    'totalPrice' => 0
                ]);
            }

            // تحديث إجمالي السعر للطلب بعد حذف العنصر
            $order->update([
                'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product removed successfully!',
                'cartCount' => $order->orderItems()->sum('quantity'),
                'totalPrice' => $order->total_price, // ✅ إرسال السعر الجديد للواجهة
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
                // تقليل الكمية بمقدار 1 وإعادة المخزون
                $orderItem->decrement('quantity');
                $orderItem->product->increment('stock');
            } else {
                // إذا كانت الكمية 1، حذف العنصر وزيادة المخزون
                $orderItem->product->increment('stock', $orderItem->quantity);
                $orderItem->delete();
            }

            // التحقق مما إذا كان الطلب فارغًا بعد الحذف
            if ($order->orderItems()->count() === 0) {
                $order->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted as it became empty!',
                    'cartCount' => 0, // لا يوجد عناصر في السلة
                ]);
            }

            // تحديث إجمالي السعر للطلب إذا لم يُحذف
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
        return view('orders.create',['users'=>$users]);
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
            'total_price' =>$request->input('total_price'),
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
        return view('orders.edit', ['order' => $order,'users'=>$users]);
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
            'total_price' =>$request->input('total_price'),
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

        // // 1️⃣ الطلبات خلال آخر 7 أيام
        // public function ordersLast7Days(Request $request)
        // {
        //     if ($request->ajax()) {
        //         $orders = Order::where('created_at', '>=', now()->subDays(7))
        //                        ->orderBy('created_at', 'desc')
        //                        ->select(['id', 'user_id', 'total_price', 'status', 'created_at']);
    
        //         return DataTables::of($orders)
        //             ->addColumn('user', function ($order) {
        //                 return $order->user->name;
        //             })
        //             ->make(true);
        //     }
        //     return view('reports.orders_last_7_days');
        // }
    
        // // 2️⃣ إجمالي المبيعات لكل منتج في آخر 30 يومًا
        // public function salesLast30Days(Request $request)
        // {
        //     if ($request->ajax()) {
        //         $sales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        //                           ->join('products', 'order_items.product_id', '=', 'products.id')
        //                           ->where('orders.created_at', '>=', now()->subDays(30))
        //                           ->select('products.id as product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
        //                           ->groupBy('products.id', 'products.name');
    
        //         return DataTables::of($sales)->make(true);
        //     }
        //     return view('reports.sales_last_30_days');
        // }
    
        // // 3️⃣ أفضل 5 عملاء حسب إجمالي الإنفاق
        // public function top5Customers(Request $request)
        // {
        //     if ($request->ajax()) {
        //         $customers = Order::join('users', 'orders.user_id', '=', 'users.id')
        //                           ->select('users.id as user_id', 'users.name', DB::raw('SUM(orders.total_price) as total_spent'))
        //                           ->groupBy('users.id', 'users.name')
        //                           ->orderByDesc('total_spent')
        //                           ->limit(5);
    
        //         return DataTables::of($customers)->make(true);
        //     }
        //     return view('reports.top_5_customers');
        // }
    
        // // 4️⃣ الطلبات التي تحتوي على أكثر من 3 منتجات مختلفة
        // public function ordersMoreThan3Products(Request $request)
        // {
        //     if ($request->ajax()) {
        //         $orders = Order::whereHas('orderItems', function ($query) {
        //                     $query->select('order_id')
        //                           ->groupBy('order_id')
        //                           ->havingRaw('COUNT(DISTINCT product_id) > 3');
        //                 })
        //                 ->select(['id', 'user_id', 'total_price', 'status', 'created_at']);
    
        //         return DataTables::of($orders)
        //             ->addColumn('user', function ($order) {
        //                 return $order->user->name;
        //             })
        //             ->make(true);
        //     }
        //     return view('reports.orders_more_than_3_products');
        // }
    
        // // 5️⃣ قائمة المنتجات التي تم شراؤها لكل طلب
        // public function orderProducts(Request $request)
        // {
        //     if ($request->ajax()) {
        //         $orderProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        //                                   ->join('products', 'order_items.product_id', '=', 'products.id')
        //                                   ->select('orders.id as order_id', DB::raw('GROUP_CONCAT(products.name SEPARATOR ", ") as products_list'))
        //                                   ->groupBy('orders.id');
    
        //         return DataTables::of($orderProducts)->make(true);
        //     }
        //     return view('reports.order_products');
        // }
    
}
