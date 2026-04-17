<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'kategori_id');
    }
}
