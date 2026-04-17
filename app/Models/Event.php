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
        'max_participant',
        'status',
        'koordinator',
        'deskripsi',
        'kategori_id',
        'banner'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function eventDetails()
    {
        return $this->hasMany(EventDetail::class, 'event_idevent');
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class, 'event_idevent');
    }
}