<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role_idrole'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_idrole', 'idrole');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'waiting_list_user_id_user', 'id_user');
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class, 'user_id_user', 'id_user');
    }
}