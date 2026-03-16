<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'idevent';

    protected $fillable = [
        'nama_event',
        'date_start',
        'date_end',
        'location',
        'max_participan',
        'status',
        'koordinator',
        'deskripsi',
        'kategori'
    ];

    public function details()
    {
        return $this->hasMany(EventDetail::class, 'event_idevent', 'idevent');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_idevent', 'idevent');
    }

    public function waitingList()
    {
        return $this->hasMany(WaitingList::class, 'event_idevent', 'idevent');
    }
}