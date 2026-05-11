@extends('layouts.admin')
@section('header_title', 'Xem tin nhắn')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-envelope-open-text"></i> Chi tiết tin nhắn</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; border-bottom: 1px solid #edf2f7; padding-bottom: 20px;">
        <div>
            <h2 style="font-size: 24px; color: #1a202c; margin-bottom: 4px;">{{ $message->subject }}</h2>
            <p style="color: #718096; font-size: 14px;">
                <i class="far fa-calendar-alt"></i> Nhận lúc {{ $message->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
        <div>
            @if($message->is_read)
            <span style="background: #c6f6d5; color: #22543d; padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-check-double"></i> Đã đọc
            </span>
            @else
            <span style="background: #fed7d7; color: #742a2a; padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-envelope"></i> Mới
            </span>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div style="background: #f7fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
            <label style="color: #718096; margin-bottom: 4px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Từ</label>
            <p style="font-weight: 600; color: #2d3748; font-size: 16px;">{{ $message->full_name }}</p>
        </div>
        <div style="background: #f7fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
            <label style="color: #718096; margin-bottom: 4px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Địa chỉ email</label>
            <p style="font-weight: 600; color: #2d3748; font-size: 16px;">
                <a href="mailto:{{ $message->email }}" style="color: #48bb78; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    {{ $message->email }} <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                </a>
            </p>
        </div>
    </div>

    <div style="background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 200px;">
        <label style="color: #718096; margin-bottom: 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; display: block;">Nội dung</label>
        <div style="line-height: 1.8; color: #4a5568; white-space: pre-wrap; font-size: 15px;">{{ $message->message }}</div>
    </div>

    <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px;">
        <form method="post" action="{{ route('admin.messages.destroy', $message) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn tin nhắn này không?')">
                <i class="fas fa-trash-alt"></i> Xóa tin nhắn
            </button>
        </form>
        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn">
            <i class="fas fa-reply"></i> Trả lời qua email
        </a>
    </div>
</div>
@endsection
