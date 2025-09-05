@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">System Settings</h1>
            <p style="color: #6b7280;">Configure platform settings and preferences</p>
        </div>
    </div>
</div>

<!-- Settings Form -->
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    
    <!-- General Settings -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h3 class="card-title">General Settings</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] }}" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] }}" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Listings Per Page</label>
                    <input type="number" name="listings_per_page" value="{{ $settings['listings_per_page'] }}" min="10" max="100"
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Commission Rate (%)</label>
                    <input type="number" name="commission_rate" value="{{ $settings['commission_rate'] }}" min="0" max="100" step="0.01"
                           style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Approval Settings -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h3 class="card-title">Approval Settings</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; gap: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="auto_approve_listings" value="1" 
                           {{ $settings['auto_approve_listings'] ? 'checked' : '' }}
                           style="width: 1.25rem; height: 1.25rem;">
                    <span style="font-weight: 600;">Auto-approve new listings</span>
                    <span style="color: #6b7280; margin-left: 0.5rem;">(Listings will be published immediately without admin review)</span>
                </label>
                
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="auto_approve_users" value="1" 
                           {{ $settings['auto_approve_users'] ? 'checked' : '' }}
                           style="width: 1.25rem; height: 1.25rem;">
                    <span style="font-weight: 600;">Auto-approve new users</span>
                    <span style="color: #6b7280; margin-left: 0.5rem;">(Users can start using the platform immediately after registration)</span>
                </label>
            </div>
        </div>
    </div>
    
    <!-- Maintenance Mode -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h3 class="card-title">Maintenance Mode</h3>
        </div>
        <div class="card-body">
            <div style="padding: 1rem; background: #fef3c7; border-radius: 0.5rem; margin-bottom: 1rem;">
                <p style="color: #92400e; margin: 0;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> Enabling maintenance mode will make the site inaccessible to regular users.
                </p>
            </div>
            
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="maintenance_mode" value="1" 
                       {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                       style="width: 1.25rem; height: 1.25rem;">
                <span style="font-weight: 600;">Enable Maintenance Mode</span>
            </label>
        </div>
    </div>
    
    <!-- Save Button -->
    <div style="display: flex; justify-content: end;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Settings
        </button>
    </div>
</form>

@push('styles')
<style>
.card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}
</style>
@endpush
@endsection
