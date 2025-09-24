<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Http\Requests\SystemManagement\Language\StoreRequest;
use App\Http\Requests\SystemManagement\Language\UpdateRequest;
use App\Http\Requests\SystemManagement\Language\DeleteRequest;
use App\Services\SystemManagement\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LanguageApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $languages = Language::select('id', 'name', 'iso_code')->filter($request)->paginate(10)->appends($request->all());

        return response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
                'total' => $languages->total(),
            ],
            'data' => $languages->items(),
            'links' => [
                'first' => $languages->url(1),
                'last' => $languages->url($languages->lastPage()),
                'prev' => $languages->previousPageUrl(),
                'next' => $languages->nextPageUrl(),
            ],
        ]);
    }

    public function store(StoreRequest $request, LanguageService $service): JsonResponse
    {
        $language = $service->create($request->validated());

        return response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
            ],
            'message' => __('global.created_success'),
            'data' => $language->only(['id', 'name', 'iso_code']),
        ], 201);
    }

    public function show(Language $language): JsonResponse
    {
        return response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
            ],
            'data' => $language->only(['id', 'name', 'iso_code']),
        ]);
    }

    public function update(UpdateRequest $request, Language $language, LanguageService $service): JsonResponse
    {
        $updatedLanguage = $service->update($language, $request->validated());

        return response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
            ],
            'message' => __('global.updated_success'),
            'data' => $updatedLanguage->only(['id', 'name', 'iso_code']),
        ]);
    }

    public function destroy(Language $language): JsonResponse
    {
        // Soft delete with description
        return response()->json([
            'message' => 'Use deleteSave endpoint for soft delete with description.',
        ], 405);
    }

    public function deleteSave(DeleteRequest $request, Language $language, LanguageService $service): JsonResponse
    {
        $service->delete($language, $request->deleted_description);

        return response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
            ],
            'message' => __('global.deleted_success'),
        ]);
    }
}