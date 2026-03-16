<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'status',
        'id_role'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'idrole');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'waiting_list_user_id_user', 'id_user');
    }

    public function waitingList()
    {
        return $this->hasMany(WaitingList::class, 'user_id_user', 'id_user');
    }
}