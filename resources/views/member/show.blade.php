@php $layout = auth()->user()->isAdmin() ? 'admin-layout' : 'member-layout'; @endphp
<x-dynamic-component :component="$layout">
<x-slot:title>Member Profile</x-slot:title>
<div class="profile-card">

    <div class="profile-header">

        <div class="profile-avatar">
            {{ strtoupper(substr($member->first_name, 0, 1)) }}
        </div>

        <div>
            <div class="profile-name">
                {{ $member->first_name }}
                {{ $member->last_name }}
            </div>

            <div class="profile-role">
                {{ $member->member_status }}
            </div>
        </div>

    </div>

    <div class="profile-grid">

        <div class="profile-item">
            <label>Email</label>
            <p>{{ $member->email }}</p>
        </div>

        <div class="profile-item">
            <label>Phone</label>
            <p>{{ $member->contact_number }}</p>
        </div>

        <div class="profile-item">
            <label>Member Type</label>
            <p>{{ $member->member_type }}</p>
        </div>

        <div class="profile-item">
            <label>Date Joined</label>
            <p>{{ $member->date_joined }}</p>
        </div>

        <div class="profile-item full-width">
            <label>Address</label>
            <p>{{ $member->address }}</p>
        </div>

    </div>

</div>
</x-dynamic-component>