<footer class="font-sans tracking-wide px-8 py-12 bg-gray-100">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('assets/images/product.svg') }}" class="h-8" alt="Logo" />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap text-gray-600">{{ __('messages.site') }}</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-600 sm:mb-0 ">
                @auth
                    <li>
                        <a href="{{ url('/dashboard') }}"
                            class="hover:underline me-4 md:me-6">{{ __('messages.dashboard') }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}"
                            class="hover:underline me-4 md:me-6">{{ __('messages.login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}" class="hover:underline me-4 md:me-6">{{ __('messages.register') }}</a>
                        </li>
                    @endif
                @endauth

                

            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-600 sm:text-center ">© 2025 <a href="#"
                class="hover:underline">{{ __('messages.site') }}</a>. {{ __('messages.rights') }}</span>
    </div>
</footer>

