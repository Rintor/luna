<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Building;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="API для зданий"
 * )
 */
class BuildingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Список зданий",
     *     tags={"Buildings"},
     *     security={{"api_key":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Найденные здания",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Building"))
     *     )
     * )
     */
    public function index()
    {
        $buildings = Building::all();

        return response()->json($buildings);
    }
}
