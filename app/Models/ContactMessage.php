<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'subject', 'message', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
