<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
     protected $fillable = ['rupee_per_point', 'updated_by'];

    public static function current()
    {
        return self::first() ?? self::create(['rupee_per_point' => 10.00]);
    }

    use HasFactory;
}
