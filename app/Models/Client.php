<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    protected $table = 'clienti';
    public $timestamps = false;

    protected  $fillable = [
        'nume', 'CNP', 'adresa', 'nr_telefon'
    ];
}
