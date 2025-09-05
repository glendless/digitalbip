<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
      protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identity_number',
        'date_of_birth',
        'phone_number',
        'occupation',
        'gender',
        'marital_status',
    ];

    public function headOfFamily()
        {
            return $this->belongsTo(HeadOfFamily::class);
        }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
