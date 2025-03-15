{{-- <x-layout>
    <div class="mx-auto max-w-screen-sm p-6 bg-white shadow-md rounded-lg my-10">
        <div class="flex items-center mb-4 space-x-4">
            <!-- Go Back Button -->
            <a href="{{ route('products.list') }}" class="inline-flex items-center justify-center w-10 h-10 text-gray-600 bg-gray-200 rounded-full hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-bold mb-4 text-xl text-gray-800">Create a new Author</h2>
        </div>
        

      
        @if (session('success'))
            <x-flash-msg msg="{{ session('success') }}" />
        @elseif (session('delete'))
            <x-flash-msg msg="{{ session('delete') }}" bg="bg-red-500" />
        @endif

       
        <form action="{{ route('products.store') }}" method="post" >
            @csrf

            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Author Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full px-3 py-2 border  rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

       
            <div class="mb-4">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author Image</label>
                <input type="file" name="image" id="image" class="block w-full text-sm text-gray-900 border  rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

           
            <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create</button>
        </form>
    </div>

</x-layout> --}}


<x-table-layout title="Create Product">
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <!-- Go Back Button -->
            <a href="{{ route('products.list') }}" 
               class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center me-2" 
               style="width: 40px; height: 40px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L2.707 7.5H14.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </a>
            <h1 class=" m-0">Create Product</h1>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name_en" class="form-label">Name (English)</label>
                <input type="text" class="form-control @error('name.en') is-invalid @enderror" id="name_en" name="name[en]" value="{{ old('name.en') }}">
                @error('name.en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name_ar" class="form-label">Name (Arabic)</label>
                <input type="text" class="form-control @error('name.ar') is-invalid @enderror" id="name_ar" name="name[ar]" value="{{ old('name.ar') }}">
                @error('name.ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}">
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('products.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-table-layout>
