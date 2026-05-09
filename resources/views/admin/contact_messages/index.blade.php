
@extends('layouts.admin')
@section('header_title', 'Messages')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Sender</th>
                <th>Subject</th>
                <th>Received At</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
            <tr @style(['background: #f0fff4' => ! $msg->is_read, 'font-weight: 600' => ! $msg->is_read])>
                <td>
                    @if($msg->is_read)
                    <span style="color: #cbd5e0;" title="Read">
                        <i class="fas fa-envelope-open"></i>
                    </span>
                    @else
                    <span style="color: #48bb78;" title="New Message">
                        <i class="fas fa-envelope"></i>
                        <span style="font-size: 10px; vertical-align: middle; margin-left: 2px; text-transform: uppercase;">New</span>
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
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-light" title="View Message">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="post" action="{{ route('admin.messages.destroy', $msg) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')" title="Delete Message">
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
                    No messages found.
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

