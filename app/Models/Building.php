<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'latitude', 'longitude'];

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    // Список зданий с их координатами
    public static function listAll()
    {
        return self::all();
    }
}

