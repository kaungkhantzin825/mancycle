@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Reports & Analytics</h1>
            <p style="color: #6b7280;">Platform performance metrics and insights</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <select id="periodSelect" onchange="updatePeriod()" style="padding: 0.625rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Last Year</option>
            </select>
            <button onclick="exportReport()" class="btn btn-primary">
                <i class="fas fa-download"></i>
                Export Report
            </button>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">New Users</p>
                <h3 style="font-size: 2rem; font-weight: 700; color: #1f2937;">{{ $stats['new_users'] }}</h3>
                <p style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">
                    <i class="fas fa-arrow-up"></i> 12% from last period
                </p>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">New Listings</p>
                <h3 style="font-size: 2rem; font-weight: 700; color: #1f2937;">{{ $stats['new_listings'] }}</h3>
                <p style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">
                    <i class="fas fa-arrow-up"></i> 8% from last period
                </p>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-list"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Messages</p>
                <h3 style="font-size: 2rem; font-weight: 700; color: #1f2937;">{{ $stats['total_messages'] }}</h3>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">
                    <i class="fas fa-arrow-down"></i> 3% from last period
                </p>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-envelope"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Approval Rate</p>
                <h3 style="font-size: 2rem; font-weight: 700; color: #1f2937;">
                    {{ $stats['approved_listings'] > 0 ? round(($stats['approved_listings'] / $stats['new_listings']) * 100) : 0 }}%
                </h3>
                <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
                    {{ $stats['approved_listings'] }} approved
                </p>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- User Growth Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User & Listing Growth</h3>
        </div>
        <div class="card-body">
            <canvas id="growthChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
    
    <!-- Category Distribution -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top Categories</h3>
        </div>
        <div class="card-body">
            <canvas id="categoryChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Top Users -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top Users by Listings</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding: 0.75rem; text-align: left;">User</th>
                        <th style="padding: 0.75rem; text-align: center;">Listings</th>
                        <th style="padding: 0.75rem; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topUsers as $user)
                    <tr>
                        <td style="padding: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.875rem;">{{ $user->name }}</div>
                                    <div style="color: #6b7280; font-size: 0.75rem;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <span style="font-weight: 600; color: #1f2937;">{{ $user->listings_count }}</span>
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <span style="padding: 0.25rem 0.5rem; background: #d1fae5; color: #065f46; border-radius: 0.25rem; font-size: 0.75rem;">
                                Active
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 1rem; text-align: center; color: #6b7280;">
                            No data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Top Categories -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Popular Categories</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding: 0.75rem; text-align: left;">Category</th>
                        <th style="padding: 0.75rem; text-align: center;">Listings</th>
                        <th style="padding: 0.75rem; text-align: center;">Growth</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCategories as $category)
                    <tr>
                        <td style="padding: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                @if($category->icon)
                                <div style="width: 32px; height: 32px; background: #f3f4f6; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                    <i class="{{ $category->icon }}"></i>
                                </div>
                                @endif
                                <span style="font-weight: 600; font-size: 0.875rem;">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <span style="font-weight: 600; color: #1f2937;">{{ $category->listings_count }}</span>
                        </td>
                        <td style="padding: 0.75rem; text-align: center;">
                            <span style="color: #10b981; font-size: 0.875rem;">
                                <i class="fas fa-arrow-up"></i> {{ rand(5, 25) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 1rem; text-align: center; color: #6b7280;">
                            No data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Update period
function updatePeriod() {
    const period = document.getElementById('periodSelect').value;
    window.location.href = `{{ route('admin.reports') }}?period=${period}`;
}

// Export report
function exportReport() {
    const period = document.getElementById('periodSelect').value;
    window.location.href = `{{ route('admin.reports.export') }}?period=${period}`;
}

// Growth Chart
const growthCtx = document.getElementById('growthChart').getContext('2d');
new Chart(growthCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Users',
            data: [12, 19, 15, 25, 22, 30, 28],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }, {
            label: 'Listings',
            data: [8, 12, 10, 18, 16, 22, 20],
            borderColor: 'rgb(16, 185, 129)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: ['Cars', 'Motorcycles', 'Second Hand', 'Others'],
        datasets: [{
            data: [45, 25, 20, 10],
            backgroundColor: [
                'rgba(239, 68, 68, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(245, 158, 11, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
@endpush
@endsection
