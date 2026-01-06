<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $connection = 'sqlsrv';  // kalau .env kamu sqlsrv, ini aman
    protected $table = 'BAGIAN';
    protected $primaryKey = 'KODEBAGIAN';
    public $timestamps = false;

    public $incrementing = false;
    protected $keyType = 'int';
}
