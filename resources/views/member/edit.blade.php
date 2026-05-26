<x-layout>

<x-slot:title>
    Edit Member
</x-slot:title>

<div class="page-header">
    <h2>Edit Member</h2>
</div>
<div class="form-card">

    <form action="{{ route('members.update', $member) }}" method="POST">

        @csrf
        @method('PUT')

        @include('member._form')

        <button type="submit" class="btn-primary">
            Update Member
        </button>

    </form>
</div>
</x-layout>