<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artwork\StoreArtworkRequest;
use App\Http\Requests\Artwork\UpdateArtworkRequest;
use App\Http\Resources\ArtworkResource;
use App\Models\Artwork;
use App\Models\Category;
use App\Services\Interfaces\Artwork\ArtworkServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function __construct(
        private readonly ArtworkServiceInterface $artworkService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'category_id', 'search', 'sort_by', 'sort_direction',
            'featured', 'is_available', 'user_id', 'price_from', 'price_to', 'year',
        ]);

        $artworks = $this->artworkService->getAllArtworks($filters);

        return response()->json([
            'status' => 'success',
            'data'   => ArtworkResource::collection($artworks)->response()->getData(true),
        ]);
    }

    public function store(StoreArtworkRequest $request): JsonResponse
    {
        $data          = $request->validated();
        $data['user_id'] = Auth::id();

        $artwork = $this->artworkService->createArtwork($data, $request->file('image'));

        return response()->json([
            'status'  => 'success',
            'message' => 'Твір успішно створено',
            'data'    => new ArtworkResource($artwork),
        ], 201);
    }

    public function show(Artwork $artwork): JsonResponse
    {
        $artwork->load(['categories', 'user', 'comments.user', 'likes.user', 'images']);

        return response()->json([
            'status' => 'success',
            'data'   => new ArtworkResource($artwork),
        ]);
    }

    public function update(UpdateArtworkRequest $request, Artwork $artwork): JsonResponse
    {
        $this->authorize('update', $artwork);

        $artwork = $this->artworkService->updateArtwork($artwork, $request->validated(), $request->file('image'));

        return response()->json([
            'status'  => 'success',
            'message' => 'Твір успішно оновлено',
            'data'    => new ArtworkResource($artwork),
        ]);
    }

    public function destroy(Artwork $artwork): JsonResponse
    {
        $this->authorize('delete', $artwork);

        $this->artworkService->deleteArtwork($artwork);

        return response()->json([
            'status'  => 'success',
            'message' => 'Твір успішно видалено',
        ]);
    }

    public function getByCategory(Category $category): JsonResponse
    {
        $artworks = $this->artworkService->getArtworksByCategory($category->id);

        return response()->json([
            'status'   => 'success',
            'data'     => ArtworkResource::collection($artworks)->response()->getData(true),
            'category' => $category,
        ]);
    }

    public function featured(): JsonResponse
    {
        $artworks = $this->artworkService->getFeaturedArtworks();

        return response()->json([
            'status' => 'success',
            'data'   => ArtworkResource::collection($artworks),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2|max:255',
        ]);

        $artworks = $this->artworkService->searchArtworks($request->input('query'));

        return response()->json([
            'status'       => 'success',
            'data'         => ArtworkResource::collection($artworks)->response()->getData(true),
            'search_query' => $request->input('query'),
        ]);
    }
}
