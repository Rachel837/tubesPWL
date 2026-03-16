<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $table = 'waiting_list';
    protected $primaryKey = 'idwaiting_list';

    protected $fillable = [
        'status',
        'user_id_user',
        'event_idevent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_user', 'id_user');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_idevent', 'idevent');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'waiting_list_idwaiting_list', 'idwaiting_list');
    }
}