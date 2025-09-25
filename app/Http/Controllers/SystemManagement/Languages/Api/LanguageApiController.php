<?php

namespace App\Http\Controllers\SystemManagement\Languages\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @OA\Tag(
 *     name="Languages",
 *     description="API endpoints for managing languages"
 * )
 */
class LanguageApiController extends Controller
{
    /**
     * Display a listing of languages.
     *
     * @OA\Get(
     *     path="/api/languages",
     *     summary="Get list of languages",
     *     tags={"Languages"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="is_active",
     *         in="query",
     *         description="Filter by active status (0 or 1)",
     *         required=false,
     *         @OA\Schema(type="integer", enum={0,1})
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
     public function index(Request $request)
     {
         $languages = Language::filter($request)
             ->paginate($request->get('per_page', 15));

         // Transform the data to include only specific fields
         $languages->getCollection()->transform(function ($language) {
             return [
                 'name' => $language->name,
                 'iso_code' => $language->iso_code,
                 'id' => $language->id
             ];
         });

         return response()->json($languages);
     }

    /**
     * Store a newly created language.
     *
     * @OA\Post(
     *     path="/api/languages",
     *     summary="Create a new language",
     *     tags={"Languages"},
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "iso_code"},
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="iso_code", type="string", maxLength=10),
     *             @OA\Property(property="is_active", type="boolean", default=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Language created successfully",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('languages')->whereNull('deleted_at'),
            ],
            'iso_code' => [
                'required',
                'string',
                'max:10',
                'regex:/^[a-z]{2,3}(-[A-Z]{2})?$/',
                Rule::unique('languages')->whereNull('deleted_at'),
            ],
            'is_active' => 'boolean',
        ]);

        // Los mensajes de validación se traducen automáticamente usando los archivos de idioma

        if ($validator->fails()) {
            return response()->json([
                'message' => __('validation.failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        $language = Language::create([
            'name' => $request->name,
            'iso_code' => $request->iso_code,
            'is_active' => $request->is_active ?? true,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => __('global.api.created_success'),
            'data' => [
                'name' => $language->name,
                'iso_code' => $language->iso_code,
                'id' => $language->id
            ]
        ], 201);
    }

    /**
     * Display the specified language.
     *
     * @OA\Get(
     *     path="/api/languages/{slug}",
     *     summary="Get a specific language",
     *     tags={"Languages"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($slug)
    {
        try {
            $language = Language::where('slug', $slug)->firstOrFail();

            return response()->json([
                'name' => $language->name,
                'iso_code' => $language->iso_code,
                'id' => $language->id
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => __('global.api.not_found')
            ], 404);
        }
    }

    /**
     * Update the specified language.
     *
     * @OA\Put(
     *     path="/api/languages/{slug}",
     *     summary="Update a language",
     *     tags={"Languages"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="iso_code", type="string", maxLength=10),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Language updated successfully",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function update(Request $request, $slug)
    {
        try {
            $language = Language::where('slug', $slug)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => __('global.api.not_found')
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('languages')->ignore($language->id)->whereNull('deleted_at'),
            ],
            'iso_code' => [
                'sometimes',
                'string',
                'max:10',
                'regex:/^[a-z]{2,3}(-[A-Z]{2})?$/',
                Rule::unique('languages')->ignore($language->id)->whereNull('deleted_at'),
            ],
            'is_active' => 'boolean',
        ]);

        // Los mensajes de validación se traducen automáticamente usando los archivos de idioma

        if ($validator->fails()) {
            return response()->json([
                'message' => __('validation.failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        $language->update($request->only(['name', 'iso_code', 'is_active']));

        return response()->json([
            'message' => __('global.api.updated_success'),
            'data' => [
                'name' => $language->name,
                'iso_code' => $language->iso_code,
                'id' => $language->id
            ]
        ]);
    }

    /**
     * Remove the specified language.
     *
     * @OA\Delete(
     *     path="/api/languages/{slug}",
     *     summary="Delete a language",
     *     tags={"Languages"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Language deleted successfully",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
     public function destroy($slug)
     {
         try {
             $language = Language::where('slug', $slug)->firstOrFail();
             $language->delete();

             return response()->json([
                 'message' => __('global.api.deleted_success')
             ]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return response()->json([
                 'message' => __('global.api.not_found')
             ], 404);
         }
     }
}

/**
 * @OA\Schema(
 *     schema="Language",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="slug", type="string", example="abc123def456"),
 *     @OA\Property(property="name", type="string", example="English"),
 *     @OA\Property(property="iso_code", type="string", example="en"),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */