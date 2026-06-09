<x-admin-layout>
    <x-slot:title>Add New Member</x-slot:title>

    <div class="member-create-page">
        <div class="breadcrumb" style="margin-bottom: 20px;">
            <a href="{{ route('admin.members.index') }}">Members</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Add New</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Member</h3>
                <p class="card-subtitle">Enter member details</p>
            </div>

            <form action="{{ route('admin.members.store') }}" method="POST" class="member-form">
                @csrf

                {{-- PERSONAL INFORMATION --}}
                <div class="form-section">
                    <h4 class="section-title">Personal Information</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Name</label>
                            <input type="text" name="name" class="form-input" required value="{{ old('name') }}">
                            @error('name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" class="form-input" required value="{{ old('email') }}">
                            @error('email') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Birthday</label>
                            <input type="date" name="birthday" class="form-input" value="{{ old('birthday') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sex</label>
                            <select name="sex" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('sex') === 'Other' ? 'selected' : '' }}>Other</option>
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
                            <input type="text" name="street" class="form-input" value="{{ old('street') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">House Number</label>
                            <input type="text" name="houseNo" class="form-input" value="{{ old('houseNo') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" class="form-input" value="{{ old('barangay') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-input" value="{{ old('city') }}">
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
                                <option value="Active" {{ old('member_status') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('member_status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Visitor" {{ old('member_status') === 'Visitor' ? 'selected' : '' }}>Visitor</option>
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
                                <option value="Regular" {{ old('member_type') === 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Youth" {{ old('member_type') === 'Youth' ? 'selected' : '' }}>Youth</option>
                                <option value="Kids" {{ old('member_type') === 'Kids' ? 'selected' : '' }}>Kids</option>
                                <option value="Senior" {{ old('member_type') === 'Senior' ? 'selected' : '' }}>Senior</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Baptism Status</label>
                            <select name="baptism_status" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Baptized" {{ old('baptism_status') === 'Baptized' ? 'selected' : '' }}>Baptized</option>
                                <option value="Not Baptized" {{ old('baptism_status') === 'Not Baptized' ? 'selected' : '' }}>Not Baptized</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Baptism Date</label>
                            <input type="date" name="baptism_date" class="form-input" value="{{ old('baptism_date') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ministry Interest</label>
                            <select name="ministry_interest" class="form-input">
                                <option value="">-- Select --</option>
                                <option value="Worship Team" {{ old('ministry_interest') === 'Worship Team' ? 'selected' : '' }}>Worship Team</option>
                                <option value="Youth Ministry" {{ old('ministry_interest') === 'Youth Ministry' ? 'selected' : '' }}>Youth Ministry</option>
                                <option value="Sunday School" {{ old('ministry_interest') === 'Sunday School' ? 'selected' : '' }}>Sunday School</option>
                                <option value="Ushers" {{ old('ministry_interest') === 'Ushers' ? 'selected' : '' }}>Ushers</option>
                                <option value="Prayer Ministry" {{ old('ministry_interest') === 'Prayer Ministry' ? 'selected' : '' }}>Prayer Ministry</option>
                                <option value="Missions" {{ old('ministry_interest') === 'Missions' ? 'selected' : '' }}>Missions</option>
                                <option value="Community Service" {{ old('ministry_interest') === 'Community Service' ? 'selected' : '' }}>Community Service</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- FORM ACTIONS --}}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Create Member
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .member-create-page {
            padding: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: var(--text-muted);
        }

        .breadcrumb-current {
            color: var(--text-dark);
        }

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
            background: white;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .card-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .member-form {
            padding: 24px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
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
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .error-text {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-lg {
            padding: 12px 24px;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: white;
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #f9fafb;
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
                justify-content: center;
            }
        }
    </style>
</x-admin-layout>
