<x-table-layout title="Create Order Item">
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('orderitems.index') }}" 
               class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center me-2" 
               style="width: 40px; height: 40px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L2.707 7.5H14.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </a>
            <h1 class="m-0">Create Order Item</h1>
        </div>

        <form action="{{ route('orderitems.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="order" class="form-label">Order</label>
                <select class="form-select @error('order_id') is-invalid @enderror" id="order" name="order_id">
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            Order #{{ $order->id }}
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <select class="form-select @error('product_id') is-invalid @enderror" id="product" name="product_id">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price at Purchase</label>
                <input type="number" step="0.01" class="form-control @error('price_at_purchase') is-invalid @enderror" id="price" name="price_at_purchase" value="{{ old('price_at_purchase') }}">
                @error('price_at_purchase')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Create Order Item</button>
            <a href="{{ route('orderitems.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-table-layout>
