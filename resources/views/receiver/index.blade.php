@extends('layouts.app')

@section('title', 'Dashboard - Receiver Messages')

@section('styles')
<style>
    .header {
        background: white;
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .header h1 {
        font-size: 28px;
        color: #1a1a2e;
        margin-bottom: 5px;
    }

    .header p {
        color: #666;
    }

    .btn-add {
        background: #4f46e5;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-add:hover {
        background: #4338ca;
        transform: translateY(-2px);
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .stat-card h3 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #1a1a2e;
    }

    .stat-card p {
        color: #666;
        font-size: 14px;
    }

    .filters {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 5px;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
        background: white;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #4f46e5;
    }

    .btn-filter {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-reset {
        background: #e5e7eb;
        color: #666;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }

    .messages-container {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .bulk-actions {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
        display: none;
        gap: 10px;
        align-items: center;
    }

    .bulk-actions.show {
        display: flex;
    }

    .btn-bulk-delete {
        background: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
    }

    .message-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 20px;
        transition: background 0.2s;
    }

    .message-item:hover {
        background: #fafafa;
    }

    .message-item.unread {
        background: #fefce8;
    }

    .message-checkbox {
        margin-right: 15px;
    }

    .message-content {
        flex: 1;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .sender-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sender-name {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 16px;
    }

    .priority-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .priority-high {
        background: #fee2e2;
        color: #dc2626;
    }

    .priority-medium {
        background: #fef3c7;
        color: #d97706;
    }

    .priority-low {
        background: #d1fae5;
        color: #10b981;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-read {
        background: #d1fae5;
        color: #10b981;
    }

    .status-unread {
        background: #fee2e2;
        color: #dc2626;
    }

    .date {
        font-size: 12px;
        color: #999;
    }

    .message-text {
        color: #555;
        line-height: 1.5;
        margin-top: 8px;
    }

    .message-actions {
        display: flex;
        gap: 10px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: #4f46e5;
        color: white;
    }

    .btn-edit {
        background: #10b981;
        color: white;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination nav {
        display: inline-block;
    }

    .pagination .flex {
        display: flex;
        gap: 5px;
        list-style: none;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        text-decoration: none;
        color: #4f46e5;
        background: white;
    }

    .pagination .active span {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: #ddd;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            text-align: center;
        }

        .filter-form {
            flex-direction: column;
        }

        .message-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <div>
            <h1> Message Dashboard</h1>
          
        </div>
        <a href="{{ route('receiver.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> New Message
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    

    <div class="filters">
        <form method="GET" action="{{ route('home') }}" class="filter-form">
            <div class="filter-group">
                <label><i class="fas fa-search"></i> Search</label>
                <input type="text" name="search" placeholder="Search by name, email, or message..." value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-flag"></i> Priority</label>
                <select name="priority">
                    <option value="">All</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-check-circle"></i> Status</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                </select>
            </div>
            <div class="filter-group">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('home') }}" class="btn-reset">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="messages-container">
        <div class="bulk-actions" id="bulkActions">
            <button class="btn-bulk-delete" id="bulkDeleteBtn">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>

        @forelse($receivers as $receiver)
            <div class="message-item {{ !$receiver->is_read ? 'unread' : '' }}" data-id="{{ $receiver->id }}">
                <div style="display: flex; align-items: flex-start;">
                    <div class="message-checkbox">
                        <input type="checkbox" class="message-select" value="{{ $receiver->id }}">
                    </div>
                    <div class="message-content">
                        <div class="message-header">
                            <div class="sender-info">
                                <span class="sender-name">
                                    {{ $receiver->sender_name }}
                                </span>
                                @if($receiver->email)
                                    <span class="date">
                                        {{ $receiver->email }}
                                    </span>
                                @endif
                                <span class="priority-badge priority-{{ $receiver->priority }}">
                                    {{ ucfirst($receiver->priority) }}
                                </span>
                                <span class="status-badge status-{{ $receiver->is_read ? 'read' : 'unread' }}">
                                    {{ $receiver->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </div>
                            <div class="date">
                                <i class="far fa-clock"></i> {{ $receiver->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                        <div class="message-text">
                            {{ Str::limit($receiver->message, 150) }}
                        </div>
                        <div class="message-actions">
                            <a href="{{ route('receiver.show', $receiver->id) }}" class="btn-action btn-view">
                                 View
                            </a>
                            <a href="{{ route('receiver.edit', $receiver->id) }}" class="btn-action btn-edit">
                                Edit
                            </a>
                            @if(!$receiver->is_read)
                                <form action="{{ route('receiver.markRead', $receiver->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-action btn-view" style="background: #10b981;">
                                        Mark Read
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('receiver.destroy', $receiver->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Messages Found</h3>
                <p>Click "New Message" to create your first message</p>
            </div>
        @endforelse

        <div class="pagination">
            {{ $receivers->withQueryString()->links() }}
        </div>
    </div>
</div>

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
            
            if (confirm(`Delete ${ids.length} message(s)?`)) {
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
</script>
@endsection