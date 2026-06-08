<x-layout>

<x-slot:title>
    Member Status Permissions
</x-slot:title>

<div class="page-header">
    <h2>Member Status Permissions</h2>
    <p style="color:#6b7280;font-size:14px;margin-top:4px;">
        Define what each member status is allowed to do across the system.
    </p>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

<div class="table-card">
    <table class="member-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Permissions Granted</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statuses as $status)
                <tr>
                    <td><strong>{{ $status->name }}</strong></td>
                    <td>
                        @php $perms = $status->permissions ?? []; @endphp
                        @if(count($perms) > 0)
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach($perms as $perm)
                                    <span style="background:#dcfce7;color:#166534;font-size:12px;padding:2px 10px;border-radius:999px;font-weight:500;">
                                        {{ $available[$perm] ?? $perm }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#9ca3af;font-size:13px;">No permissions assigned</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.member-statuses.edit', $status) }}"
                           class="btn-primary" style="font-size:13px;padding:6px 14px;">
                            Edit Permissions
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-layout>
