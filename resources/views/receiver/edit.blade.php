@extends('layouts.app')

@section('title', 'Edit Message')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-header h2 {
        font-size: 28px;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .form-header p {
        color: #666;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        outline: none;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-group textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .btn-submit {
        width: 100%;
        background: #4f46e5;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    .btn-back {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        color: #4f46e5;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #fecaca;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-container">
        <div class="form-header">
            <h2> Edit Message</h2>
          
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('receiver.update', $receiver->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Sender Name <span class="required">*</span></label>
                    <input type="text" name="sender_name" value="{{ old('sender_name', $receiver->sender_name) }}" placeholder="Enter sender name">
                    @error('sender_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $receiver->email) }}" placeholder="sender@example.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $receiver->phone) }}" placeholder="+1 234 567 8900">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="low" {{ old('priority', $receiver->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $receiver->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $receiver->priority) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Message <span class="required">*</span></label>
                <textarea name="message" placeholder="Write your message here...">{{ old('message', $receiver->message) }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                 Update Message
            </button>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</div>
@endsection