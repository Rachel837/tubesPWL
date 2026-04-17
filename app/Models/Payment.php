<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'idpayment';

    public $timestamps = false;

    protected $fillable = [
        'registrations_idregistrations',
        'payment_proof'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registrations_idregistrations');
    }
}