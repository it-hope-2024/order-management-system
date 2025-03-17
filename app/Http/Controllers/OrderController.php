<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class OrderController extends Controller
{



//     public function addToCart($productId)
// {
//     try {
//         // جلب المنتج
//         $product = Product::findOrFail($productId);

//         // التحقق من توفر المخزون
//         if ($product->stock > 0) {
//             $order = auth()->user()->orders()->where('status', 'pending')->first();
//             if (!$order) {
//                 $order = Order::create([
//                     'user_id' => auth()->id(),
//                     'status' => 'pending',
//                     'total_price' => 0,
//                 ]);
//             }

//             // إضافة المنتج إلى الطلب
//             $order->orderItems()->create([
//                 'product_id' => $product->id,
//                 'quantity' => 1,
//                 'price_at_purchase' => $product->price,
//             ]);

//             // تقليل الكمية من المخزون
//             $product->decrement('stock');

//             // تحديث إجمالي السعر للطلب
//             $order->update([
//                 'total_price' => $order->orderItems->sum(fn($item) => $item->quantity * $item->price_at_purchase),
//             ]);

//             // إرسال المخزون الجديد للواجهة
//             return response()->json([
//                 'success' => true,
//                 'cartCount' => $order->orderItems()->count(),
//                 'newStock' => $product->fresh()->stock, // تحديث الكمية بعد التعديل
//             ]);
//         }

//         return response()->json(['success' => false, 'message' => 'Product out of stock.'], 400);

//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
//     }
// }

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
        $order = auth()->user()->orders()->where('status', 'pending')->first();
        if (!$order) {
            $order = Order::create([
                'user_id' => auth()->id(),
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
    // 🗑️ حذف المنتج من السلة
    public function removeItem($id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $orderItem->product->increment('stock', $orderItem->quantity);

        $orderItem->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف المنتج من السلة!', 'cartCount' => Order::where('user_id', Auth::id())->where('status', 'pending')->first()->orderItems()->sum('quantity') ?? 0]);
    }

    // ✅ تأكيد الطلب
    public function confirmOrder()
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'pending')->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'لا يوجد طلب معلق لتأكيده!']);
        }

        $order->update(['status' => 'completed']);

        return response()->json(['success' => true, 'message' => 'تم تأكيد الطلب بنجاح!', 'cartCount' => 0]);
    }

    // 🛍️ عرض الطلبات الحالية
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->with('orderItems.product')
                        ->get();

        return view('orders.my-orders', compact('orders'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}


// namespace App\Http\Controllers;

// use App\Models\Order;
// use App\Models\Product;
// use App\Models\OrderItem;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class OrderController extends Controller
// {
//     public function store(Request $request)
//     {
//         $request->validate([
//             'products' => 'required|array',
//             'products.*.id' => 'required|exists:products,id',
//             'products.*.quantity' => 'required|integer|min:1',
//         ]);

//         $totalPrice = 0;
//         foreach ($request->products as $productData) {
//             $product = Product::findOrFail($productData['id']);

//             if ($product->stock < $productData['quantity']) {
//                 return back()->with('error', "Insufficient stock for {$product->getTranslation('name', 'en')}");
//             }

//             $totalPrice += $product->price * $productData['quantity'];
//         }

//         $order = Order::create([
//             'user_id' => Auth::id(),
//             'total_price' => $totalPrice,
//         ]);

//         foreach ($request->products as $productData) {
//             $product = Product::findOrFail($productData['id']);
//             OrderItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $product->id,
//                 'quantity' => $productData['quantity'],
//                 'price_at_purchase' => $product->price,
//             ]);

//             $product->decrement('stock', $productData['quantity']);
//         }

//         return redirect()->route('orders.index')->with('success', 'Order placed successfully');
//     }
// }
