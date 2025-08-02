<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API сервис",
 *     version="1.0.0",
 *     description="Описание API"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Основной сервер"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     name="X-API-KEY",
 *     in="header"
 * )
 *
 * @OA\Schema(
 *     schema="Organization",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ООО Ромашка"),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OrganizationPhone")
 *     ),
 *     @OA\Property(
 *         property="building",
 *         ref="#/components/schemas/Building"
 *     ),
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Activity")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Building",
 *     required={"id", "address"},
 *     @OA\Property(property="id", type="integer", example=42),
 *     @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина, д. 10"),
 *     @OA\Property(property="latitude", type="number", format="float", example=55.7558),
 *     @OA\Property(property="longitude", type="number", format="float", example=37.6173)
 * )
 *
 * @OA\Schema(
 *     schema="Activity",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=7),
 *     @OA\Property(property="name", type="string", example="Медицинские услуги"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=null)
 * )
 *
 * @OA\Schema(
 *     schema="OrganizationPhone",
 *     required={"organization_id", "phone"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="organization_id", type="integer", example=10),
 *     @OA\Property(property="phone", type="string", example="+7 123 456 7890")
 * )
 */

class OpenApi {}