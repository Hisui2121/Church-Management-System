<x-layout>

<x-slot:title>
    Edit Permissions — {{ $memberStatus->name }}
</x-slot:title>

<div class="page-header">
    <h2>Edit Permissions: <span style="color:#468770;">{{ $memberStatus->name }}</span></h2>
    <a href="{{ route('admin.member-statuses.index') }}" style="font-size:13px;color:#6b7280;">
        ← Back to all statuses
    </a>
</div>

<div class="table-card" style="max-width:640px;">

    <form method="POST" action="{{ route('admin.member-statuses.update', $memberStatus) }}">
        @csrf
        @method('PUT')

        <p style="font-size:14px;color:#6b7280;margin-bottom:20px;">
            Check the actions that users with <strong>{{ $memberStatus->name }}</strong> status are allowed to perform.
            Admins always have full access regardless of this setting.
        </p>

        @php $current = $memberStatus->permissions ?? []; @endphp

        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($available as $key => $label)
                <label style="display:flex;align-items:center;gap:12px;cursor:pointer;padding:12px 16px;border:1px solid #e5e7eb;border-radius:8px;transition:background .15s;"
                       onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                    <input
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $key }}"
                        {{ in_array($key, $current) ? 'checked' : '' }}
                        style="width:18px;height:18px;accent-color:#468770;cursor:pointer;"
                    >
                    <div>
                        <div style="font-weight:600;font-size:14px;color:#111827;">{{ $label }}</div>
                        <div style="font-size:12px;color:#9ca3af;">{{ $key }}</div>
                    </div>
                </label>
            @endforeach
        </div>

        <div style="margin-top:28px;display:flex;gap:12px;">
            <button type="submit" class="btn-primary">Save Permissions</button>
            <a href="{{ route('admin.member-statuses.index') }}"
               style="padding:10px 20px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;color:#374151;text-decoration:none;">
                Cancel
            </a>
        </div>
    </form>

</div>

</x-layout>
