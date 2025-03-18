<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderItem::with(['order', 'product'])->select('order_items.*');
            return DataTables::of($data)
                ->addColumn('order_id', fn ($row) => $row->order->id)
                ->addColumn('product_name', fn ($row) => $row->product->name)
                ->addColumn('quantity', fn ($row) => $row->quantity)
                ->addColumn('price_at_purchase', fn ($row) => number_format($row->price_at_purchase, 2))
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('orderitems.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                        <form action="' . route('orderitems.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
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
        return view('orderitems.create',['orders'=>$orders,'products'=>$products]);
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
        return view('orderitems.edit', ['orders'=>$orders,'orderitem'=>$orderitem,'products'=>$products]);
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
