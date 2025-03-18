<x-layout> 
    <div class="container mx-auto px-4 py-6 min-h-[500px]">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-800 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            My Pending Orders</h2>
    
        @if ($orders->isEmpty())
            <p class="text-gray-500 text-center">No Pending Orders</p>
        @else
            @foreach ($orders as $order)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Order ID#{{ $order->id }}</h3>
    
                    <table class="w-full border-collapse border border-gray-300 text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-4 py-3">OrderItem ID</th>
                                <th class="border px-4 py-3">Product ID</th>
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
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->id }}</td>
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->product->id }}</td>
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->product->getTranslation('name', app()->getLocale()) }}</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->quantity }}</td>
                                    <td class="border px-4 py-3">{{ $item->price_at_purchase  }}$</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->price_at_purchase * $item->quantity }}$</td>
                                    <td class="border px-4 py-3 flex justify-center space-x-2">
                                        <button onclick="decreaseItem({{ $item->id }})"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus"><path d="M5 12h14"/></svg>
                                        </button>
                                        <button onclick="removeItem({{ $item->id }})"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                    <p class="mt-4 text-lg font-bold text-gray-700">Total Price: 
                        <span class="text-green-600">{{ $order->total_price }}$</span>
                    </p>
    
                    {{-- <button onclick="confirmOrder()" 
                        class="mt-4 bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg> Confirm Order
                    </button> --}}
                    <button onclick="confirmOrder()" 
    class="mt-4 bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition w-full md:w-auto flex items-center justify-center gap-2">
    
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check">
        <path d="M18 6 7 17l-5-5"/>
        <path d="m22 10-7.5 7.5L13 16"/>
    </svg> 

    <span>Confirm Order</span>
</button>
                </div>
            @endforeach
        @endif
    </div>
    </x-layout>
    