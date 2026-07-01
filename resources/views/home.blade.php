@extends('layouts.app')

@section('title', 'Dashboard - Receiver Messages')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .dashboard-header {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dashboard-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1e1e2f;
        margin: 0;
    }
    .btn-primary-custom {
        background: #4f46e5;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #4338ca;
        color: #ffffff;
    }
    .analytics-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    .chart-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 15px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .chart-box h3 {
        font-size: 15px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 15px;
        width: 100%;
        text-align: left;
    }
    .chart-container-wrapper {
        position: relative;
        height: 140px;
        width: 100%;
        max-width: 240px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .filter-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-layout {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: flex-end;
    }
    .filter-item label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .filter-item input, .filter-item select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        background: #ffffff;
        outline: none;
    }
    .filter-item input:focus, .filter-item select:focus {
        border-color: #4f46e5;
    }
    .filter-actions {
        display: flex;
        gap: 10px;
    }
    .btn-submit-filter {
        background: #4f46e5;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }
    .btn-reset-filter {
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        padding: 9px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        text-align: center;
    }
    .data-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .bulk-panel {
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
        display: none;
    }
    .bulk-panel.show {
        display: flex;
    }
    .btn-danger-custom {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }
    .record-row {
        border-bottom: 1px solid #f3f4f6;
        padding: 16px 0;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }
    .record-row:last-child {
        border-bottom: none;
    }
    .record-row.unread-row {
        background: #fffbeb;
        margin-left: -20px;
        margin-right: -20px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .record-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 6px;
    }
    .meta-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .sender-title {
        font-weight: 600;
        color: #111827;
        font-size: 15px;
    }
    .sender-mail {
        font-size: 13px;
        color: #6b7280;
    }
    .badge-custom {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-high { background: #fee2e2; color: #dc2626; }
    .badge-medium { background: #fef3c7; color: #d97706; }
    .badge-low { background: #d1fae5; color: #10b981; }
    .badge-read { background: #e5e7eb; color: #4b5563; }
    .badge-unread { background: #fee2e2; color: #dc2626; }
    .record-time {
        font-size: 12px;
        color: #9ca3af;
    }
    .record-body {
        color: #374151;
        font-size: 14px;
        line-height: 1.5;
    }
    .row-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }
    .action-link {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: none;
        background: #f3f4f6;
        color: #4b5563;
        cursor: pointer;
    }
    .action-link:hover {
        background: #e5e7eb;
    }
    .action-view { background: #e0e7ff; color: #4f46e5; }
    .action-view:hover { background: #c7d2fe; }
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    .empty-placeholder {
        text-align: center;
        padding: 40px 0;
        color: #9ca3af;
    }
    .empty-placeholder i {
        font-size: 48px;
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        .filter-layout {
            grid-template-columns: 1fr;
        }
        .record-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div class="dashboard-title">
            <h1>Message Dashboard</h1>
        </div>
        <a href="{{ route('receiver.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> New Message
        </a>
    </div>

    <div class="analytics-section">
        <div class="chart-box">
            <h3>Message Status</h3>
            <div class="chart-container-wrapper">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="chart-box">
            <h3>Priority Distribution</h3>
            <div class="chart-container-wrapper">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="filter-box">
        <form method="GET" action="{{ route('home') }}" class="filter-layout">
            <div class="filter-item">
                <label>Search</label>
                <input type="text" name="search" placeholder="Name, email or keyword..." value="{{ request('search') }}">
            </div>
            <div class="filter-item">
                <label>Priority</label>
                <select name="priority">
                    <option value="">All</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Status</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-submit-filter">Filter</button>
                <a href="{{ route('home') }}" class="btn-reset-filter">Reset</a>
            </div>
        </form>
    </div>

    <div class="data-card">
        <div class="bulk-panel" id="bulkActions">
            <button class="btn-danger-custom" id="bulkDeleteBtn">Delete Selected</button>
        </div>

        <div id="messageList">
            @forelse($receivers as $receiver)
                <div class="record-row {{ !$receiver->is_read ? 'unread-row' : '' }}" id="message-row-{{ $receiver->id }}">
                    <div class="pt-1">
                        <input type="checkbox" class="message-select" value="{{ $receiver->id }}">
                    </div>
                    <div class="flex-1">
                        <div class="record-meta">
                            <div class="meta-left">
                                <span class="sender-title">{{ $receiver->sender_name }}</span>
                                @if($receiver->email)
                                    <span class="sender-mail">{{ $receiver->email }}</span>
                                @endif
                                <span class="badge-custom badge-{{ $receiver->priority }}">
                                    {{ ucfirst($receiver->priority) }}
                                </span>
                                <span class="badge-custom {{ $receiver->is_read ? 'badge-read' : 'badge-unread' }}" id="status-badge-{{ $receiver->id }}">
                                    {{ $receiver->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </div>
                            <div class="record-time">
                                <i class="far fa-clock"></i> {{ $receiver->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                        <div class="record-body">
                            {{ Str::limit($receiver->message, 140) }}
                        </div>
                        <div class="row-actions">
                            <a href="{{ route('receiver.show', $receiver->id) }}" class="action-link action-view">View</a>
                            <a href="{{ route('receiver.edit', $receiver->id) }}" class="action-link">Edit</a>
                            @if(!$receiver->is_read)
                                <button type="button" class="action-link btn-mark-read" data-id="{{ $receiver->id }}" id="mark-read-btn-{{ $receiver->id }}">
                                    Mark Read
                                </button>
                            @endif
                            <form action="{{ route('receiver.destroy', $receiver->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link text-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-placeholder">
                    <i class="fas fa-inbox"></i>
                    <h3>No Messages Found</h3>
                    <p>Click "New Message" to add data.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-container">
            {{ $receivers->withQueryString()->links() }}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const checkboxes = document.querySelectorAll('.message-select');
    const bulkActions = document.getElementById('bulkActions');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    function updateBulkActions() {
        const selected = document.querySelectorAll('.message-select:checked');
        if (selected.length > 0) {
            bulkActions.classList.add('show');
        } else {
            bulkActions.classList.remove('show');
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selected = document.querySelectorAll('.message-select:checked');
            const ids = Array.from(selected).map(cb => cb.value);
            if (ids.length === 0) return;
            
            if (confirm(`Delete ${ids.length} selected record(s)?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("receiver.bulkDelete") }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    $(document).on('click', '.btn-mark-read', function() {
        const id = $(this).data('id');
        const button = $(this);
        
        $.ajax({
            url: `/receiver/${id}/read`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $(`#message-row-${id}`).removeClass('unread-row');
                    $(`#status-badge-${id}`).removeClass('badge-unread').addClass('badge-read').text('Read');
                    button.remove();
                    loadCharts();
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            }
        });
    });

    let statusChart, priorityChart;
    function loadCharts() {
        $.ajax({
            url: '{{ route("analytics.data") }}',
            method: 'GET',
            success: function(response) {
                if (statusChart) statusChart.destroy();
                if (priorityChart) priorityChart.destroy();

                const ctxStatus = document.getElementById('statusChart').getContext('2d');
                statusChart = new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: response.status.labels,
                        datasets: [{
                            data: response.status.data,
                            backgroundColor: ['#10b981', '#ef4444']
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
                        }
                    }
                });

                const ctxPriority = document.getElementById('priorityChart').getContext('2d');
                priorityChart = new Chart(ctxPriority, {
                    type: 'bar',
                    data: {
                        labels: response.priority.labels,
                        datasets: [{
                            data: response.priority.data,
                            backgroundColor: ['#dc2626', '#d97706', '#10b981']
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: true, 
                        plugins: { legend: { display: false } },
                        scales: { 
                            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9 } } },
                            x: { ticks: { font: { size: 9 } } }
                        } 
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        loadCharts();
    });
</script>
@endsection