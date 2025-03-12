<footer class="font-sans tracking-wide px-8 py-12 bg-gray-100">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{route('home')}}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('assets/images/product.svg') }}" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-600">{{__('messages.site')}}</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-600 sm:mb-0 ">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-600 sm:text-center ">© 2025 <a href="#" class="hover:underline">Order Management System</a>. All Rights Reserved.</span>
    </div>
</footer>

