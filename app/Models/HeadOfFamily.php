<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'identity_number',
        'date_of_birth',
        'phone_number',
        'occupation',
        'gender',
        'marital_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssitanceRecipient::class);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

}
