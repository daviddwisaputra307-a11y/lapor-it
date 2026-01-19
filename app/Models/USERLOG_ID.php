<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USERLOG_ID extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'USERLOG_ID';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
