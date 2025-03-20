<x-table-layout title="Create Order">
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('orders.index') }}"
                class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center me-2"
                style="width: 40px; height: 40px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L2.707 7.5H14.5a.5.5 0 0 1 .5.5z" />
                </svg>
            </a>
            <h1 class="m-0">Create Order</h1>
        </div>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <select class="form-select @error('user_id') is-invalid @enderror" id="user" name="user_id">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="number" step="0.01" class="form-control @error('total_price') is-invalid @enderror"
                    id="total_price" name="total_price" value="{{ old('total_price') }}">
                @error('total_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Create Order</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-table-layout>
