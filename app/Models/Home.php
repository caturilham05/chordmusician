<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'homes';
    protected $fillable = ['title', 'intro', 'content', 'active'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public static function getHome(){
        return self::first();
    }
}
