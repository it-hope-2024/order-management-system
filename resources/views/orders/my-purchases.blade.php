<x-layout>
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-800 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18l-2 14H5L3 3z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21a1 1 0 01-2 0m-4 0a1 1 0 01-2 0"></path>
            </svg>
            My Purchases
        </h2>
    
        @if ($orders->isEmpty())
            <p class="text-gray-500 text-center flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 9.172a4 4 0 005.656 5.656m-5.656-5.656A4 4 0 0114.828 14.83m-5.656-5.658A4 4 0 019.172 9.17m5.656 5.658A4 4 0 0114.828 14.83M15 19H9m3-10V5"></path>
                </svg>
                You have no completed orders.
            </p>
        @else
            @foreach ($orders as $order)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-gray-700 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18l-2 14H5L3 3z"></path>
                        </svg>
                        Order #{{ $order->id }}
                    </h3>
    
                    <table class="w-full border-collapse border border-gray-300 text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">
                                        <svg class="w-5 h-5 text-gray-700 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18l-2 14H5L3 3z"></path>
                                        </svg>
                                        Product
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">
                                        <svg class="w-5 h-5 text-gray-700 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12l4 4m-4-4l4-4"></path>
                                        </svg>
                                        Quantity
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">
                                        <svg class="w-5 h-5 text-gray-700 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-4.418 0-8 2.686-8 6v2h16v-2c0-3.314-3.582-6-8-6z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 14c0 1.105-.672 2-1.5 2S13 15.105 13 14"></path>
                                        </svg>
                                        Total Price
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->product->name }}</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->quantity }}</td>
                                    <td class="border px-4 py-3 text-green-600 font-semibold">
                                        {{ $item->price_at_purchase * $item->quantity }}$
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                    <p class="mt-4 text-lg font-bold text-gray-700 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-4.418 0-8 2.686-8 6v2h16v-2c0-3.314-3.582-6-8-6z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 14c0 1.105-.672 2-1.5 2S13 15.105 13 14"></path>
                        </svg>
                        Total: <span class="text-green-600 ml-1">{{ $order->total_price }}$</span>
                    </p>
                </div>
            @endforeach
        @endif
    </div>
    </x-layout>
    