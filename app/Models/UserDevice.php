<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    use HasFactory;
    protected $table = 'user_devices';

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function user() : BelongsTo {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
