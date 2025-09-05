<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'thumbnail',
        'name',
        'category',
        'description',
        'amount',
        'provider',
        'is_available'
    ];

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssitanceRecipient::class);
    }
}
