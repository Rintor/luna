<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="API для организаций"
 * )
 */
class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations/building/{buildingId}",
     *     summary="Получить организации по зданию",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="buildingId",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций по зданию",
     *         @OA\JsonContent(
     *             @OA\Property(property="building", ref="#/components/schemas/Building"),
     *             @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *         )
     *     )
     * )
     */
    public function byBuilding(int $buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $organizations = $building->organizations()->with('phones', 'activities')->get();

        return response()->json([
            'building' => $building,
            'organizations' => $organizations,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/{activityId}",
     *     summary="Получить организации по виду деятельности",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="activityId",
     *         in="path",
     *         required=true,
     *         description="ID активности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций по виду деятельности",
     *         @OA\JsonContent(
     *             @OA\Property(property="activity", ref="#/components/schemas/Activity"),
     *             @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *         )
     *     )
     * )
     */
    public function byActivity(int $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $organizations = $activity->organizations()->with('phones', 'building')->get();

        return response()->json([
            'activity' => $activity,
            'organizations' => $organizations,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/radius",
     *     summary="Получить организации по радиусу",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(name="latitude", in="query", required=true, @OA\Schema(type="number", format="float")),
     *     @OA\Parameter(name="longitude", in="query", required=true, @OA\Schema(type="number", format="float")),
     *     @OA\Parameter(name="radius", in="query", required=true, @OA\Schema(type="number", format="float", minimum=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Организации в радиусе",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     )
     * )
     */
    public function byRadius(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:1',
        ]);

        $organizations = Organization::searchInRadius(
            $request->latitude,
            $request->longitude,
            $request->radius
        )->load('phones', 'building', 'activities');

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/rectangle",
     *     summary="Получить организации в прямоугольнике",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(name="lat_min", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="lat_max", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="lng_min", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="lng_max", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Response(
     *         response=200,
     *         description="Организации в прямоугольнике",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     )
     * )
     */
    public function byRectangle(Request $request)
    {
        $request->validate([
            'lat_min' => 'required|numeric',
            'lat_max' => 'required|numeric|gte:lat_min',
            'lng_min' => 'required|numeric',
            'lng_max' => 'required|numeric|gte:lng_min',
        ]);

        $organizations = Organization::searchInRectangle(
            $request->lat_min,
            $request->lat_max,
            $request->lng_min,
            $request->lng_max,
        )->load('phones', 'building', 'activities');

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Получить организацию по ID",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Данные организации",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     )
     * )
     */
    public function show(int $id)
    {
        $organization = Organization::with('phones', 'building', 'activities')->findOrFail($id);
        return response()->json($organization);
    }

    /**
     * @OA\Post(
     *     path="/api/organizations/search/activity",
     *     summary="Поиск организаций по имени активности",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"activity_name"},
     *             @OA\Property(property="activity_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организации по активности",
     *         @OA\JsonContent(
     *             @OA\Property(property="root_activity", ref="#/components/schemas/Activity"),
     *             @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *         )
     *     ),
     *     @OA\Response(response=404, description="Activity not found")
     * )
     */
    public function searchByActivity(Request $request)
    {
        $request->validate(['activity_name' => 'required|string']);

        $rootActivity = Activity::where('name', $request->activity_name)->first();
        if (!$rootActivity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $activities = $rootActivity->getDescendantsWithLimit(3);
        $activityIds = $activities->pluck('id');

        $organizations = Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with('phones', 'building', 'activities')->get();

        return response()->json([
            'root_activity' => $rootActivity,
            'organizations' => $organizations,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search/name/{name}",
     *     summary="Поиск организаций по имени",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(name="name", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Найденные организации",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     )
     * )
     */
    public function searchByName($name)
    {
        $organizations = Organization::searchByName($name)->load('phones', 'building', 'activities');

        return response()->json($organizations);
    }
}
