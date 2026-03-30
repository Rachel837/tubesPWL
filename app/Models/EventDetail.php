<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $table = 'event_detail';
    protected $primaryKey = 'idevent_detail';

    protected $fillable = [
        'date',
        'seri',
        'time_start',
        'time_end',
        'deskripsi',
        'event_idevent'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_idevent', 'idevent');
    }

    public function tickets()
    {
        return $this->hasMany(Tiket::class, 'event_detail_idevent_detail', 'idevent_detail');
    }
}