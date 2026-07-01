@extends('layouts.app')

@section('title', 'View Message')

@section('styles')
<style>
    .message-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .message-header {
        background: #4f46e5;
        color: white;
        padding: 25px;
    }
    .message-header h2 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 4px 0;
    }
    .message-header p {
        font-size: 13px;
        opacity: 0.9;
        margin: 0;
    }
    .message-body {
        padding: 25px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .info-item label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 2px;
    }
    .info-item span {
        font-size: 14px;
        color: #1f2937;
        font-weight: 500;
    }
    .priority-indicator {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    .ind-high { background: #fee2e2; color: #dc2626; }
    .ind-medium { background: #fef3c7; color: #d97706; }
    .ind-low { background: #d1fae5; color: #10b981; }
    .content-container {
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        margin-bottom: 25px;
    }
    .content-container h4 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .content-container p {
        font-size: 14px;
        color: #374151;
        line-height: 1.6;
        margin: 0;
    }
    .reply-section {
        border-top: 1px dashed #e5e7eb;
        padding-top: 20px;
        margin-bottom: 25px;
    }
    .reply-section h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 12px;
    }
    .reply-section textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        outline: none;
        resize: vertical;
    }
    .reply-section textarea:focus {
        border-color: #4f46e5;
    }
    .btn-send-reply {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 9px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 8px;
    }
    .footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f3f4f6;
        padding-top: 20px;
    }
    .btn-neutral {
        background: #f3f4f6;
        color: #4b5563;
        padding: 9px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }
    .btn-danger-link {
        color: #ef4444;
        background: none;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="message-container">
        <div class="message-header">
            <h2>Message Details</h2>
            <p>From {{ $receiver->sender_name }}</p>
        </div>

        <div class="message-body">
            <div class="info-grid">
                <div class="info-item">
                    <label>Sender Name</label>
                    <span>{{ $receiver->sender_name }}</span>
                </div>
                @if($receiver->email)
                    <div class="info-item">
                        <label>Email Address</label>
                        <span>{{ $receiver->email }}</span>
                    </div>
                @endif
                @if($receiver->phone)
                    <div class="info-item">
                        <label>Phone Number</label>
                        <span>{{ $receiver->phone }}</span>
                    </div>
                @endif
                <div class="info-item">
                    <label>Priority</label>
                    <span class="priority-indicator ind-{{ $receiver->priority }}">
                        {{ ucfirst($receiver->priority) }}
                    </span>
                </div>
            </div>

            <div class="content-container">
                <h4>Message Body</h4>
                <p>{{ $receiver->message }}</p>
            </div>

            @if($receiver->email)
                <div class="reply-section">
                    <h3>Direct Email Reply</h3>
                    <form action="{{ route('receiver.reply', $receiver->id) }}" method="POST">
                        @csrf
                        <textarea name="reply_message" rows="4" placeholder="Write your email response here..." required></textarea>
                        <button type="submit" class="btn-send-reply">Send Response</button>
                    </form>
                </div>
            @endif

            <div class="footer-actions">
                <a href="{{ route('home') }}" class="btn-neutral">Back to Dashboard</a>
                <form action="{{ route('receiver.destroy', $receiver->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-link">Delete Record</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection