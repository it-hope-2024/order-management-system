{{-- 
@props(['product'])

<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-between min-h-[400px]">
    <div>
        <div class="h-56 w-full">
            <a href="#">
                <img class="mx-auto h-full dark:hidden" src={{ asset('assets/images/product.svg') }} alt="" />
            </a>
        </div>

        <div class="pt-6">
            <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white block min-h-[48px]">
                {{ $product->getTranslation('name', app()->getLocale()) }}
            </a>


            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.in-stock') }}: 
                <span id="product-stock-{{ $product->id }}" class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? $product->stock : __('messages.out-of-stock') }}
                </span>
            </p>
        </div>
    </div>

    <div class="mt-auto">
        <div class="mt-4 flex items-center justify-between">
            <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">
                ${{ $product->price }}
            </p>

            @if ($product->stock > 0)
                <button type="button" id="add-to-cart-btn-{{ $product->id }}" onclick="addToCart({{ $product->id }})"
                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white 
                    hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 min-w-[160px]">
                    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                    </svg>
                    {{ __('messages.add-to-cart') }}
                </button>
            @else
                <p class="text-sm font-semibold text-red-500 min-w-[160px] text-center">
                    {{ __('messages.out-of-stock') }}
                </p>
            @endif
        </div>
    </div>
</div>

 --}}

 @props(['product'])

<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-between min-h-[400px]">
    <div>
        <div class="h-56 w-full">
            <a href="#">
                <img class="mx-auto h-full dark:hidden" src={{ asset('assets/images/product.svg') }} alt="" />
            </a>
        </div>

        <div class="pt-6">
            <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white block min-h-[48px]">
                {{ $product->getTranslation('name', app()->getLocale()) }}
            </a>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.in-stock') }}: 
                <span id="product-stock-{{ $product->id }}" class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? $product->stock : __('messages.out-of-stock') }}
                </span>
            </p>
        </div>
    </div>

    {{-- <div class="mt-auto">
        @if ($product->stock > 0)
            <div class="mt-4 flex flex-col items-center gap-3">
                <!-- زر التحكم في الكمية -->
                <div class="flex items-center justify-center w-full">
                    <button type="button" onclick="decreaseQuantity({{ $product->id }})"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-l hover:bg-gray-400">
                        -
                    </button>
                    <input type="number" id="quantity-{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}" 
                        class="w-14 text-center border-t border-b border-gray-300 dark:border-gray-600">
                    <button type="button" onclick="increaseQuantity({{ $product->id }}, {{ $product->stock }})"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-r hover:bg-gray-400">
                        +
                    </button>
                </div>

                <!-- زر إضافة إلى السلة -->
                <button type="button" id="add-to-cart-btn-{{ $product->id }}" onclick="addToCart({{ $product->id }})"
                    class="w-full bg-blue-700 text-white px-5 py-2.5 text-sm font-medium rounded-lg 
                    hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 
                    dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="-ms-2 me-2 h-5 w-5 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                    </svg>
                    {{ __('messages.add-to-cart') }}
                </button>
            </div>
        @else
            <button disabled 
                class="w-full bg-gray-400 text-white px-5 py-2.5 text-sm font-medium rounded-lg 
                hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 cursor-not-allowed">
                {{ __('messages.out-of-stock') }}
            </button>
        @endif
    </div> --}}
    <div class="mt-auto">
        @if ($product->stock > 0)
            <div class="mt-4 flex flex-col items-center gap-3">
                <!-- زر التحكم في الكمية -->
                <div class="flex items-center justify-center w-full">
                    <button type="button" onclick="decreaseQuantity({{ $product->id }})"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-l hover:bg-gray-400">
                        -
                    </button>
                    <input type="number" id="quantity-{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}" 
                        class="w-14 text-center border-t border-b border-gray-300 dark:border-gray-600">
                    <button type="button" onclick="increaseQuantity({{ $product->id }}, {{ $product->stock }})"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-r hover:bg-gray-400">
                        +
                    </button>
                </div>
    
                @auth
                    <!-- إذا كان المستخدم مسجلاً دخول، يظهر زر إضافة إلى السلة -->
                    <button type="button" id="add-to-cart-btn-{{ $product->id }}" onclick="addToCart({{ $product->id }})"
                        class="w-full bg-blue-700 text-white px-5 py-2.5 text-sm font-medium rounded-lg 
                        hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 
                        dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="-ms-2 me-2 h-5 w-5 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                        </svg>
                        {{ __('messages.add-to-cart') }}
                    </button>
                @endauth
                
                @guest
                    <!-- إذا كان المستخدم غير مسجل، يظهر زر يفتح Swal -->
                    <button type="button" onclick="showAuthAlert()"
                        class="w-full bg-red-600 text-white px-5 py-2.5 text-sm font-medium rounded-lg 
                        hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 
                        dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                        <svg class="-ms-2 me-2 h-5 w-5 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                        </svg>
                        {{ __('messages.add-to-cart') }}
                    </button>
                @endguest
            </div>
        @else
            <button disabled 
                class="w-full bg-gray-400 text-white px-5 py-2.5 text-sm font-medium rounded-lg 
                hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 cursor-not-allowed">
                {{ __('messages.out-of-stock') }}
            </button>
        @endif
    </div>
</div>














