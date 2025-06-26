<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Gas Gawe Application",
 *         version="1.0.0",
 *         description="API Dokumentasi untuk aplikasi gas gawe.",
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
*      @OA\Components(
 *          @OA\SecurityScheme(
 *              securityScheme="bearerAuth",
 *              type="http",
 *              scheme="bearer",
 *              bearerFormat="JWT"
 *          )
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000/api",
 *         description="Local Development"
 *     ),
 *     @OA\Server(
 *         url="https://gasgawe.com/api",
 *         description="Production Server"
 *     )
 * )
 */

class OpenApiSpec
{
    // Kosong, hanya untuk menyimpan anotasi
}