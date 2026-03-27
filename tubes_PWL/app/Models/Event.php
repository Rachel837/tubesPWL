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
        'koordinat',
        'deskripsi',
        'kategori'
    ];
}