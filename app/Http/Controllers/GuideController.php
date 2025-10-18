<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListGuidesRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GuideController extends Controller
{
    public function index(ListGuidesRequest $request): AnonymousResourceCollection
    {
        $query = Guide::query()
            ->where('is_active', true)
            ->orderBy('name');

        if ($request->filled('min_experience')) {
            $query->where('experience_years', '>=', $request->integer('min_experience'));
        }

        return GuideResource::collection($query->get());
    }
}
