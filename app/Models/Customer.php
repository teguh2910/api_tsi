<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $primaryKey = '_id';
    protected $dates = ['deleted_at'];
    protected $guarded=[];

}
