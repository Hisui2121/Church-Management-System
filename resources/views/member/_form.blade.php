<div class="form-grid">

    <div class="form-group">
        <label>First Name</label>

        <input type="text"  name="first_name" value="{{ old('first_name', $member->first_name ?? '') }}">
    </div>

    <div class="form-group">
        <label>Last Name</label>

        <input type="text" name="last_name" value="{{ old('last_name', $member->last_name ?? '') }}">
    </div>

    <div class="form-group">
        <label>Birthdate</label>

        <input type="date" name="birthdate" value="{{ old('birthdate', $member->birthdate ?? '') }}">
    </div>

    <div class="form-group">
        <label>Gender</label>

        <select name="gender">

            <option value="">Select</option>

            <option value="Male" {{ old('gender', $member->gender ?? '') == 'Male' ? 'selected' : '' }}>
                Male
            </option>

            <option value="Female" {{ old('gender', $member->gender ?? '') == 'Female' ? 'selected' : '' }}>
                Female
            </option>

        </select>
    </div>

    <div class="form-group">
        <label>Contact Number</label>

        <input type="text" name="contact_number" value="{{ old('contact_number', $member->contact_number ?? '') }}">
    </div>

    <div class="form-group">
        <label>Email</label>

        <input type="email"  name="email" value="{{ old('email', $member->email ?? '') }}">
    </div>

    <div class="form-group full-width">
        <label>Address</label>

        <textarea name="address">{{ old('address', $member->address ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>Member Status</label>

        <select name="member_status">

            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Visitor">Visitor</option>
            <option value="Volunteer">Volunteer</option>

        </select>
    </div>

    <div class="form-group">
        <label>Member Type</label>

        <select name="member_type">

            <option value="Regular">Regular</option>
            <option value="Youth">Youth</option>
            <option value="Kids">Kids</option>
            <option value="Senior">Senior</option>

        </select>
    </div>

    <div class="form-group">
        <label>Date Joined</label>

        <input type="date" name="date_joined" value="{{ old('date_joined', $member->date_joined ?? '') }}"
        >
    </div>

</div>