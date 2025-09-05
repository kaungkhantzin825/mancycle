@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Edit User</h1>
            <p style="color: #6b7280;">Update user information and permissions</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Users
        </a>
    </div>
</div>

<!-- User Edit Form -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Left Column - User Information -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Information</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" id="userEditForm">
                    @csrf
                    @method('PATCH')
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('name')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('phone')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Role</label>
                            <select name="role" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="dealer" {{ $user->role == 'dealer' ? 'selected' : '' }}>Dealer</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                            <select name="status" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                            @error('status')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    @if($user->role == 'dealer')
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Commission Rate (%)</label>
                        <input type="number" name="commission_rate" value="{{ old('commission_rate', $user->commission_rate) }}" 
                               min="0" max="100" step="0.01"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <small style="color: #6b7280;">Commission rate for dealer transactions</small>
                        @error('commission_rate')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                    
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fef3c7; border-radius: 0.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #92400e;">
                            <i class="fas fa-key"></i> Change Password
                        </label>
                        <input type="password" name="password" placeholder="Leave blank to keep current password"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <small style="color: #92400e;">Only fill this if you want to change the user's password</small>
                        @error('password')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="flex: 1;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Right Column - User Stats and Activity -->
    <div>
        <!-- User Stats -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title">User Statistics</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Total Listings</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                            {{ $user->listings()->count() }}
                        </div>
                    </div>
                    
                    <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Active Listings</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">
                            {{ $user->listings()->where('status', 'approved')->count() }}
                        </div>
                    </div>
                    
                    <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Messages Sent</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">
                            {{ \App\Models\Message::where('sender_id', $user->id)->count() }}
                        </div>
                    </div>
                    
                    <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Member Since</div>
                        <div style="font-size: 0.875rem; font-weight: 600; color: #6b7280;">
                            {{ $user->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Account Information -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title">Account Information</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="color: #6b7280; font-size: 0.875rem;">User ID</span>
                        <span style="font-weight: 600;">#{{ $user->id }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Email Verified</span>
                        <span>
                            @if($user->email_verified_at)
                            <span style="color: #10b981;"><i class="fas fa-check-circle"></i> Yes</span>
                            @else
                            <span style="color: #ef4444;"><i class="fas fa-times-circle"></i> No</span>
                            @endif
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Last Login</span>
                        <span style="font-size: 0.875rem;">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Last Updated</span>
                        <span style="font-size: 0.875rem;">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                        <i class="fas fa-eye"></i>
                        View Full Profile
                    </a>
                    
                    @if(!$user->email_verified_at)
                    <form method="POST" action="{{ route('admin.users.verify', $user) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" style="width: 100%;">
                            <i class="fas fa-check"></i>
                            Mark Email as Verified
                        </button>
                    </form>
                    @endif
                    
                    @if($user->status != 'blocked')
                    <form method="POST" action="{{ route('admin.users.block', $user) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger" style="width: 100%;"
                                onclick="return confirm('Are you sure you want to block this user?')">
                            <i class="fas fa-ban"></i>
                            Block User
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.users.unblock', $user) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" style="width: 100%;">
                            <i class="fas fa-check"></i>
                            Unblock User
                        </button>
                    </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                          onsubmit="return confirm('Are you sure? This action cannot be undone!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%; background: #dc2626;">
                            <i class="fas fa-trash"></i>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    padding: 1rem 1.5rem;
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
    justify-content: center;
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

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}
</style>
@endpush
@endsection
