<x-admin-layout>
    <x-slot:title>Edit {{ $member->name }}</x-slot:title>

    <div class="member-edit-page">
        <div class="breadcrumb" style="margin-bottom: 20px;">
            <a href="{{ route('admin.members.index') }}">Members</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('admin.members.show', $member->id) }}">{{ $member->name }}</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Edit</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Member Information</h3>
                <p class="card-subtitle">Update member details</p>
            </div>

            <form action="{{ route('admin.members.update', $member->id) }}" method="POST" class="member-form">
                @csrf
                @method('PUT')

                {{-- PERSONAL INFORMATION --}}
                <div class="form-section">
                    <h4 class="section-title">Personal Information</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Name</label>
                            <input type="text" name="name" value="{{ $member->name }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" value="{{ $member->email }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ $member->phone }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Birthday</label>
                            <input type="date" name="birthday" value="{{ $member->birthday }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sex</label>
                            <select name="sex" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Male" {{ $member->sex === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $member->sex === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $member->sex === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ADDRESS INFORMATION --}}
                <div class="form-section">
                    <h4 class="section-title">Address</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Street</label>
                            <input type="text" name="street" value="{{ $member->street }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">House Number</label>
                            <input type="text" name="houseNo" value="{{ $member->houseNo }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" value="{{ $member->barangay }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ $member->city }}" class="form-input">
                        </div>
                    </div>
                </div>

                {{-- STATUS INFORMATION --}}
                <div class="form-section">
                    <h4 class="section-title">Status</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Member Status</label>
                            <select name="member_status" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Active" {{ $member->memberStatus?->name === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $member->memberStatus?->name === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Visitor" {{ $member->memberStatus?->name === 'Visitor' ? 'selected' : '' }}>Visitor</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- CHURCH INFORMATION --}}
                <div class="form-section">
                    <h4 class="section-title">Church Information</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Member Type</label>
                            <select name="member_type" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Regular" {{ $member->member_type === 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Youth" {{ $member->member_type === 'Youth' ? 'selected' : '' }}>Youth</option>
                                <option value="Kids" {{ $member->member_type === 'Kids' ? 'selected' : '' }}>Kids</option>
                                <option value="Senior" {{ $member->member_type === 'Senior' ? 'selected' : '' }}>Senior</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Baptism Status</label>
                            <select name="baptism_status" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Baptized" {{ $member->baptism_status === 'Baptized' ? 'selected' : '' }}>Baptized</option>
                                <option value="Not Baptized" {{ $member->baptism_status === 'Not Baptized' ? 'selected' : '' }}>Not Baptized</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Baptism Date</label>
                            <input type="date" name="baptism_date" value="{{ $member->baptism_date }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ministry Interest</label>
                            <select name="ministry_interest" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Worship Team" {{ $member->ministry_interest === 'Worship Team' ? 'selected' : '' }}>Worship Team</option>
                                <option value="Youth Ministry" {{ $member->ministry_interest === 'Youth Ministry' ? 'selected' : '' }}>Youth Ministry</option>
                                <option value="Sunday School" {{ $member->ministry_interest === 'Sunday School' ? 'selected' : '' }}>Sunday School</option>
                                <option value="Ushers" {{ $member->ministry_interest === 'Ushers' ? 'selected' : '' }}>Ushers</option>
                                <option value="Prayer Ministry" {{ $member->ministry_interest === 'Prayer Ministry' ? 'selected' : '' }}>Prayer Ministry</option>
                                <option value="Missions" {{ $member->ministry_interest === 'Missions' ? 'selected' : '' }}>Missions</option>
                                <option value="Community Service" {{ $member->ministry_interest === 'Community Service' ? 'selected' : '' }}>Community Service</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- FORM ACTIONS --}}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .member-edit-page {
            padding: 0;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-label.required::after {
            content: ' *';
            color: var(--danger);
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-dark);
            background: var(--white);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
</x-admin-layout>
