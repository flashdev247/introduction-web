
@extends('layouts.admin')
@section('header_title', 'Tin nhắn')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-envelope"></i> Tin nhắn liên hệ</h1>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Trạng thái</th>
                <th>Người gửi</th>
                <th>Tiêu đề</th>
                <th>Nhận lúc</th>
                <th style="text-align: right;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
            <tr @style(['background: #f0fff4' => ! $msg->is_read, 'font-weight: 600' => ! $msg->is_read])>
                <td>
                    @if($msg->is_read)
                    <span style="color: #cbd5e0;" title="Đã đọc">
                        <i class="fas fa-envelope-open"></i>
                    </span>
                    @else
                    <span style="color: #48bb78;" title="Tin nhắn mới">
                        <i class="fas fa-envelope"></i>
                        <span style="font-size: 10px; vertical-align: middle; margin-left: 2px; text-transform: uppercase;">Mới</span>
                    </span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #2d3748;">{{ $msg->full_name }}</span>
                        <span style="color: #a0aec0; font-size: 12px; font-weight: 400;">{{ $msg->email }}</span>
                    </div>
                </td>
                <td>
                    <span style="color: #4a5568;">{{ Str::limit($msg->subject, 50) }}</span>
                </td>
                <td>
                    <span style="color: #718096; font-size: 13px;">{{ $msg->created_at->diffForHumans() }}</span>
                </td>
                <td>
                    <div class="action-buttons" style="justify-content: flex-end;">
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-light" title="Xem tin nhắn">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="post" action="{{ route('admin.messages.destroy', $msg) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa tin nhắn này?')" title="Xóa tin nhắn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 48px; color: #a0aec0;">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                    Không có tin nhắn nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($messages->hasPages())
<div style="margin-top: 24px;">
    {{ $messages->links() }}
</div>
@endif

<style>
    tr.unread td {
        border-left: 4px solid #48bb78;
    }
</style>
@endsection

