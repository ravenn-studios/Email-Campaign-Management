<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    public    $table = 'files';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'name',
        'extension',
        'path'
    ];
}
