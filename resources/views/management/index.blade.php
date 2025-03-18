<x-table-layout title="Management">
    <div class="container text-center my-5">
        <h1 class="fw-bold text-dark mb-4">Welcome to Management</h1>

        <div class="card shadow-lg mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="table-light">
                            <td class="fw-semibold text-start">User ID:</td>
                            <td class="text-dark text-start">{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-start">User Name:</td>
                            <td class="text-success text-start">{{ $user->name }}</td>
                        </tr>
                        <tr class="table-light">
                            <td class="fw-semibold text-start">User Email:</td>
                            <td class="text-success text-start">{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-table-layout>
