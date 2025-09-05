@extends('layouts.admin')

@section('title', 'System Logs')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">System Logs</h1>
            <p style="color: #6b7280;">View and manage application logs</p>
        </div>
        <button class="btn btn-danger" onclick="alert('Clear logs feature coming soon!')">
            <i class="fas fa-trash"></i>
            Clear Logs
        </button>
    </div>
</div>

<!-- Coming Soon Message -->
<div class="card">
    <div class="card-body" style="text-align: center; padding: 4rem;">
        <i class="fas fa-file-alt" style="font-size: 4rem; color: #9ca3af; margin-bottom: 1rem;"></i>
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #4b5563; margin-bottom: 0.5rem;">Log Viewer Coming Soon</h2>
        <p style="color: #6b7280;">The system log viewer is currently under development.</p>
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

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}
</style>
@endpush
@endsection
