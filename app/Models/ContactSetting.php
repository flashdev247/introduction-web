<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'site_name', 'logo', 'email', 'phone', 'address', 'contact_info', 'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
