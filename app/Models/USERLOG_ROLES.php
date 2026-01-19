<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USERLOG_ROLES extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'USERLOG_ROLES';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
