<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *    title="Laravel v11 API",
 *    version="1.0.0"
 * )
 *
 * * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your bearer token in the format: `Bearer {token}`"
 * )
 */
class OpenApiController extends Controller
{
    //
}
