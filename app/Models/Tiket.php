<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    protected $primaryKey = 'idtiket';

    protected $fillable = [
        'jenis_tiket',
        'harga',
        'kuota',
        'deskripsi',
        'event_detail_idevent_detail'
    ];

    public function eventDetail()
    {
        return $this->belongsTo(EventDetail::class, 'event_detail_idevent_detail');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'tiket_idtiket');
    }
}