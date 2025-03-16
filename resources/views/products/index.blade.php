<x-layout>

    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach




            </div>

        </div>
        {{-- Pagination links --}}
        <div>
            {{ $products->links() }}
        </div>
    </section>





</x-layout>
