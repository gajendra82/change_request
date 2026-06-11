<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Settings</h1>
        <p class="subtitle">Manage your profile and account preferences</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="crms-card">
                <div class="crms-card-header"><h5>Profile Information</h5></div>
                <div class="crms-card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="crms-card mb-4">
                <div class="crms-card-header"><h5>Update Password</h5></div>
                <div class="crms-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="crms-card">
                <div class="crms-card-header"><h5>Delete Account</h5></div>
                <div class="crms-card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
