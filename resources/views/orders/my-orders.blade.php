<x-layout> 
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">🛒 My Pending Orders</h2>
    
        @if ($orders->isEmpty())
            <p class="text-gray-500 text-center">No Pending Orders</p>
        @else
            @foreach ($orders as $order)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Order ID#{{ $order->id }}</h3>
    
                    <table class="w-full border-collapse border border-gray-300 text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-4 py-3">Product</th>
                                <th class="border px-4 py-3">Quantity</th>
                                <th class="border px-4 py-3">Price Per Unit</th>
                                <th class="border px-4 py-3">Total</th>
                                <th class="border px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->product->name }}</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->quantity }}</td>
                                    <td class="border px-4 py-3">{{ $item->price_at_purchase  }}$</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->price_at_purchase * $item->quantity }}$</td>
                                    <td class="border px-4 py-3 flex justify-center space-x-2">
                                        <button onclick="decreaseItem({{ $item->id }})"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                            ➖
                                        </button>
                                        <button onclick="removeItem({{ $item->id }})"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                            🗑️
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                    <p class="mt-4 text-lg font-bold text-gray-700">Total Price: 
                        <span class="text-green-600">{{ $order->total_price }}$</span>
                    </p>
    
                    <button onclick="confirmOrder()" 
                        class="mt-4 bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition w-full md:w-auto">
                        ✅ Confirm Order
                    </button>
                </div>
            @endforeach
        @endif
    </div>
    </x-layout>
    