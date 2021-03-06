<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

// Models
use App\Models\Battleplan;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
      // Properties
      'username',
      'email',
      'password',
      'email_verified_at',
      'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationships
     */
    public function battleplans() {
      return $this->hasMany(Battleplan::class, 'owner_id');
    }

    public function votes() {
      return $this->hasMany(Vote::class);
    }

}
