<x-layout>

<x-slot:title>
    Review Registration
</x-slot:title>

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="review-page">

    {{-- BACKGROUND OVERLAY --}}
    <div class="review-overlay"></div>

    <div class="review-container">

        {{-- STEP INDICATOR --}}
        <div class="step-indicator">
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step active"></div>
        </div>

        <h1 class="review-title">
            Review Your Information
        </h1>

        <p class="review-subtitle">
            Please confirm your details before creating your account.
        </p>

        {{-- ACCOUNT DETAILS --}}
        <div class="review-section">

            <div class="review-header">
                <h2>Account Details</h2>

                <a href="/register/account" class="edit-btn">
                    Edit
                </a>
            </div>

            <div class="review-grid">

                <div class="review-item">
                    <label>Name</label>
                    <p>{{ $data['name'] }}</p>
                </div>

                <div class="review-item">
                    <label>Email</label>
                    <p>{{ $data['email'] }}</p>
                </div>

                <div class="review-item">
                    <label>Password</label>
                    <p>••••••••••••</p>
                </div>

            </div>

        </div>

        {{-- PERSONAL DETAILS --}}
        <div class="review-section">

            <div class="review-header">
                <h2>Personal Details</h2>

                <a href="/register/personal" class="edit-btn">
                    Edit
                </a>
            </div>

            <div class="review-grid">

                <div class="review-item">
                    <label>City</label>
                    <p>{{ $data['city'] }}</p>
                </div>

                <div class="review-item">
                    <label>Barangay</label>
                    <p>{{ $data['barangay'] }}</p>
                </div>

                <div class="review-item">
                    <label>Street</label>
                    <p>{{ $data['street'] ?? 'N/A' }}</p>
                </div>

                <div class="review-item">
                    <label>House Number</label>
                    <p>{{ $data['houseNo'] ?? 'N/A' }}</p>
                </div>

                <div class="review-item">
                    <label>Birthday</label>
                    <p>{{ $data['birthday'] }}</p>
                </div>

                <div class="review-item">
                    <label>Sex</label>
                    <p>{{ ucfirst($data['sex']) }}</p>
                </div>

                <div class="review-item">
                    <label>Phone</label>
                    <p>{{ $data['phone'] ?? 'N/A' }}</p>
                </div>

            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="review-actions">

            <a href="/register/personal" class="back-btn">
                ← Back
            </a>

            <form action="/register/submit" method="POST">
                @csrf

                <button type="submit" class="confirm-btn">
                    Create Account
                </button>
            </form>

        </div>

    </div>

</div>

</x-layout>