<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class USERLOG extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $connection = 'sqlsrv';  // kalau .env kamu sqlsrv, ini aman
    protected $table = 'USERLOG';
    public $timestamps = false;

    // Set primary key jika perlu
    protected $primaryKey = 'USLOGNM';
    public $incrementing = false;
    protected $keyType = 'string';
}
