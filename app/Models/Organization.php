<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'building_id'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function phones()
    {
        return $this->hasMany(OrganizationPhone::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class)->withTimestamps();
    }

    // Поиск организаций по названию (частичное совпадение)
    public static function searchByName(string $name)
    {
        return self::where('name', 'like', "%{$name}%")->get();
    }

    // Поиск организаций в радиусе (в метрах) от точки (широта, долгота)
    public static function searchInRadius(float $lat, float $lng, float $radiusMeters)
    {
        // Радиус Земли в метрах
        $earthRadius = 6371000;

        return self::select('organizations.*')
            ->join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->whereRaw("
                (
                    $earthRadius * acos(
                        cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    )
                ) < ?
            ", [$lat, $lng, $lat, $radiusMeters])
            ->get();
    }

    // Поиск организаций в прямоугольной области (lat/lng)
    public static function searchInRectangle(float $latMin, float $latMax, float $lngMin, float $lngMax)
    {
        return self::select('organizations.*')
            ->join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->whereBetween('latitude', [$latMin, $latMax])
            ->whereBetween('longitude', [$lngMin, $lngMax])
            ->get();
    }
}