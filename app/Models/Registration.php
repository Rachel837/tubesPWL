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
        'tiket_idtiket',
        'waiting_list_idwaiting_list',
        'waiting_list_user_id_user'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_idtiket', 'idtiket');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'registrations_idregistrations', 'idregistrations');
    }
}