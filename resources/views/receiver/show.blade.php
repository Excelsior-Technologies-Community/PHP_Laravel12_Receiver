@extends('layouts.app')

@section('title', 'View Message')

@section('styles')
<style>
    .message-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .message-header {
        background: #4f46e5;
        color: white;
        padding: 30px;
    }

    .message-header h2 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .message-body {
        padding: 30px;
    }

    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-label {
        width: 140px;
        font-weight: 600;
        color: #666;
    }

    .info-value {
        flex: 1;
        color: #333;
    }

    .priority-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
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
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-read {
        background: #d1fae5;
        color: #10b981;
    }

    .status-unread {
        background: #fee2e2;
        color: #dc2626;
    }

    .message-content {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin: 20px 0;
        line-height: 1.6;
        color: #333;
        border: 1px solid #e0e0e0;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #10b981;
        color: white;
    }

    .btn-back {
        background: #6b7280;
        color: white;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="message-container">
        <div class="message-header">
            <h2> Message Details</h2>
            <p>Viewing message from {{ $receiver->sender_name }}</p>
        </div>

        <div class="message-body">
            <div class="info-row">
                <div class="info-label">Sender Name:</div>
                <div class="info-value">{{ $receiver->sender_name }}</div>
            </div>

            @if($receiver->email)
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $receiver->email }}</div>
            </div>
            @endif

            @if($receiver->phone)
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div class="info-value">{{ $receiver->phone }}</div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-label">Priority:</div>
                <div class="info-value">
                    <span class="priority-badge priority-{{ $receiver->priority }}">
                        {{ ucfirst($receiver->priority) }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $receiver->is_read ? 'read' : 'unread' }}">
                        {{ $receiver->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Received:</div>
                <div class="info-value">{{ $receiver->created_at->format('F d, Y h:i A') }}</div>
            </div>

            <div class="message-content">
                <strong><i class="fas fa-quote-left"></i> Message:</strong>
                <p style="margin-top: 10px;">{{ $receiver->message }}</p>
            </div>

            <div class="action-buttons">
                <a href="{{ route('receiver.edit', $receiver->id) }}" class="btn btn-edit">
                     Edit Message
                </a>
                <a href="{{ route('home') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <form action="{{ route('receiver.destroy', $receiver->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this message?')">
                         Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection