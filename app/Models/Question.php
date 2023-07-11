<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Question extends Model
{
    use HasFactory, HasApiTokens,SoftDeletes;
    protected $connection   = 'mongodb';
    protected $primaryKey   = '_id';
    protected $dates        = ['deleted_at'];
    protected $guarded      = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
