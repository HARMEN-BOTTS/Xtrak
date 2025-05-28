<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLogin extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['user_id', 'login_at', 'logout_at'];
    public function getDurationAttribute()
    {
        if ($this->logout_at !== null) {
            $logoutAt = Carbon::parse($this->logout_at);
            $loginAt = Carbon::parse($this->login_at);
            return $logoutAt->diffInSeconds($loginAt);
        } else {
            return 0;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
