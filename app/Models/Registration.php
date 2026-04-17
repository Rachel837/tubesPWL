<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registrations';
    protected $primaryKey = 'idregistrations';

    protected $fillable = [
        'status',
        'qr_code',
        'waiting_list_idwaiting_list',
        'tiket_idtiket',
        'user_id',
        'is_attended',
        'attended_at'
    ];

    public function waitingList()
    {
        return $this->belongsTo(WaitingList::class, 'waiting_list_idwaiting_list');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_idtiket');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'registrations_idregistrations');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}