<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Company Name *</label>
        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $client->company_name ?? '') }}" required>
        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Company Code *</label>
        <input type="text" name="company_code" class="form-control @error('company_code') is-invalid @enderror" value="{{ old('company_code', $client->company_code ?? '') }}" required>
        @error('company_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">GST Number</label>
        <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number', $client->gst_number ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Website</label>
        <input type="url" name="website" class="form-control" value="{{ old('website', $client->website ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $client->address ?? '') }}</textarea>
    </div>
    <div class="col-md-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city', $client->city ?? '') }}"></div>
    <div class="col-md-3"><label class="form-label">State</label><input type="text" name="state" class="form-control" value="{{ old('state', $client->state ?? '') }}"></div>
    <div class="col-md-3"><label class="form-label">Country</label><input type="text" name="country" class="form-control" value="{{ old('country', $client->country ?? 'India') }}"></div>
    <div class="col-md-3"><label class="form-label">Pincode</label><input type="text" name="pincode" class="form-control" value="{{ old('pincode', $client->pincode ?? '') }}"></div>
    <div class="col-md-4">
        <label class="form-label">Primary Contact Name *</label>
        <input type="text" name="primary_contact_name" class="form-control" value="{{ old('primary_contact_name', $client->primary_contact_name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Primary Contact Email *</label>
        <input type="email" name="primary_contact_email" class="form-control" value="{{ old('primary_contact_email', $client->primary_contact_email ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Primary Contact Mobile</label>
        <input type="text" name="primary_contact_mobile" class="form-control" value="{{ old('primary_contact_mobile', $client->primary_contact_mobile ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select" required>
            <option value="active" @selected(old('status', $client->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $client->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="form-control" accept="image/*">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $client->notes ?? '') }}</textarea>
    </div>
</div>
