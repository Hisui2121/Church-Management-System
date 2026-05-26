<x-layout>

<x-slot:title>
    Add Member
</x-slot:title>

<div class="page-header">
    <h2>Add Member</h2>
</div>

<div class="form-card">

    <form action="{{ route('members.store') }}" method="POST">

        @csrf

        @include('member._form')

        <button type="submit" class="btn-primary">
            Save Member
        </button>

    </form>
</div>

</x-layout>