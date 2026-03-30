<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'idpayment';

    protected $fillable = [
        'registrations_idregistrations'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registrations_idregistrations', 'idregistrations');
    }
}