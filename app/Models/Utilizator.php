<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilizator extends Model
{
    protected $table = 'utilizatori';
    public $timestamps = false;

    protected  $fillable = [
        'id', 'Nume', 'Prenume', 'Username', 'Parola'
    ];


    public function dosar() {
        return $this->hasOne(Dosar::class);
    }
}
