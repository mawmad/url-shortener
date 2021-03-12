<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'code',
        'original_link'
    ];
}
