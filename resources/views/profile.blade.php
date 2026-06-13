<x-admin-layout>
    <x-slot:title>Profile</x-slot:title>

    <div class="page-header">
        <h1 class="page-title">Profile</h1>
        <p class="page-subtitle">Manage your profile</p>
    </div>

    <div class="card">
        <div class="card-body">
            <p>This is a placeholder profile page.</p>
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        </div>
    </div>
</x-admin-layout>