<x-layout>

<x-slot:title>
    Members
</x-slot:title>

<div class="page-header">

    <h2>Church Members</h2>

    <a href="{{ route('members.create') }}" class="btn-primary">
        + Add Member
    </a>

</div>

@if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif
<div class="table-card">

    <table class="member-table">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($members as $member)

                <tr>

                    <td>

                        <div class="member-info">

                            <div class="member-avatar">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                            </div>

                            <div>

                                <div class="member-name">
                                    {{ $member->first_name }}
                                    {{ $member->last_name }}
                                </div>

                            </div>

                        </div>

                    </td>

                        <td>
                            
                        <div class="member-email">
                                {{ $member->email }}
                            </div>
                        </td>

                        <td>

                            <span class="badge badge-{{ strtolower($member->member_status) }}">
                                {{ $member->member_status }}
                            </span>

                        </td>

                        <td>{{ $member->member_type }}</td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('members.show', $member) }}" class="action-btn view-btn">
                                    View
                                </a>

                                <a href="{{ route('members.edit', $member) }}" class="action-btn edit-btn">
                                    Edit
                                </a>

                                <form action="{{ route('members.destroy', $member) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="action-btn delete-btn" >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        No members found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
</div>

{{ $members->links() }}

</x-layout>