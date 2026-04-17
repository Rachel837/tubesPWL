<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $table = 'waiting_list';
    protected $primaryKey = 'idwaiting_list';

    protected $fillable = [
        'status',
        'event_idevent',
        'user_id_user',
        'users_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_idevent');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'waiting_list_idwaiting_list');
    }
}