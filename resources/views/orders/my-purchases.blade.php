<x-layout title="My Purchases">
    <div class="container mx-auto px-4 py-6 min-h-[500px]">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-800 mr-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-shopping-cart">
                <circle cx="8" cy="21" r="1" />
                <circle cx="19" cy="21" r="1" />
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
            </svg>
            My Purchases
            <span class="text-green-600 text-lg ml-3"> (Total: {{ number_format($totalOrdersPrice, 2) }}$)</span>
        </h2>

        @if ($orders->isEmpty())
            <p class="text-gray-500 text-center flex items-center justify-center">

                You have no completed orders.
            </p>
        @else
            @foreach ($orders as $order)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">

                        Order #{{ $order->id }}
                    </h3>

                    <table class="w-full border-collapse border border-gray-300 text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">

                                        OrderItem ID
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">

                                        Product ID
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">

                                        Product
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">

                                        Quantity
                                    </span>
                                </th>
                                <th class="border px-4 py-3 text-center">
                                    <span class="inline-flex items-center">

                                        Total Price
                                    </span>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->id }}</td>
                                    <td class="border px-4 py-3 text-gray-800">{{ $item->product->id }}</td>
                                    <td class="border px-4 py-3 text-gray-800">
                                        {{ $item->product->getTranslation('name', app()->getLocale()) }}</td>
                                    <td class="border px-4 py-3 font-semibold">{{ $item->quantity }}</td>
                                    <td class="border px-4 py-3 text-green-600 font-semibold">
                                        {{ $item->price_at_purchase * $item->quantity }}$
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p class="mt-4 text-lg font-bold text-gray-700 flex items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 mr-2" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-award">
                            <path
                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526" />
                            <circle cx="12" cy="8" r="6" />
                        </svg>
                        Total For Order # {{ $order->id }}: <span
                            class="text-green-600 ml-1">{{ $order->total_price }}$</span>
                    </p>
                </div>
            @endforeach
        @endif
    </div>
</x-layout>
