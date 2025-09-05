@extends('layouts.admin')

@section('title', 'Backup & Restore')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Backup & Restore</h1>
            <p style="color: #6b7280;">Manage system backups and restore points</p>
        </div>
        <button class="btn btn-primary" onclick="alert('Backup feature coming soon!')">
            <i class="fas fa-plus"></i>
            Create Backup
        </button>
    </div>
</div>

<!-- Coming Soon Message -->
<div class="card">
    <div class="card-body" style="text-align: center; padding: 4rem;">
        <i class="fas fa-database" style="font-size: 4rem; color: #9ca3af; margin-bottom: 1rem;"></i>
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #4b5563; margin-bottom: 0.5rem;">Backup System Coming Soon</h2>
        <p style="color: #6b7280;">The backup and restore functionality is currently under development.</p>
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
