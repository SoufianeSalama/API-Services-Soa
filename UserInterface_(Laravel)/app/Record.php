<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'sord',
        'devicesn',
        'clientinfo',
        'complaint',
        'diagnose',
        'statuskey',
        'userid'
    ];
}