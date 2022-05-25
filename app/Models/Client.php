<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clienti';
    public $timestamps = false;

    public static function pluck(string $string, string $string1)
    {
    }
}
