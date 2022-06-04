<?php

namespace App;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
/**
 * Post
 *
 * @mixin Eloquent
 */
class Dosar extends Model
{

    protected $table = 'dosare';
    public $timestamps = false;
    protected  $fillable = [
        'client_id', 'problema_drept', 'data_inregistrare', 'user_id', 'status', 'informatii'
    ];

}
