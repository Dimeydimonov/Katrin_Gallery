<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArtworkRequest;
use App\Http\Requests\Admin\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Models\ArtworkImage;
use App\Models\Category;
use App\Services\Interfaces\Artwork\ArtworkServiceInterface;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArtworkController extends Controller
{
    // DI
    public function __construct(
        private readonly ArtworkServiceInterface $artworkService,
        private readonly ImageUploadService $imageUploadService
    ) {}

    public function index(Request $request)
    {
        $query = Artwork::with(['user', 'categories'])
            ->withCount(['likes', 'comments']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_available', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_available', false);
            }
        }

        if ($request->filled('category')) {
            $categoryId = $request->category;
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
        }

        $artworks   = $query->latest()->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.artworks.index', compact('artworks', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.artworks.create', compact('categories'));
    }

    public function store(StoreArtworkRequest $request)
    {
        $validated              = $request->validated();
        $validated['user_id']   = Auth::id();
        $validated['is_available'] = $request->boolean('is_published');

        DB::beginTransaction();
        try {
            $artwork = $this->artworkService->createArtwork($validated);

            if ($request->hasFile('images')) {
                $this->imageUploadService->uploadMultipleImages($request->file('images'), $artwork->id);
            }

            DB::commit();

            return redirect()->route('admin.artworks.index')
                ->with('success', 'Твір успішно створено!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Artwork creation failed', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Помилка при створенні твору: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Artwork $artwork)
    {
        $artwork->load(['user', 'categories', 'comments.user', 'likes.user', 'images']);

        return view('admin.artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        $categories         = Category::active()->orderBy('name')->get();
        $selectedCategories = $artwork->categories->pluck('id')->toArray();
        $artwork->load('images');

        return view('admin.artworks.edit', compact('artwork', 'categories', 'selectedCategories'));
    }

    public function update(UpdateArtworkRequest $request, Artwork $artwork)
    {
        $validated                 = $request->validated();
        $validated['is_available'] = $request->boolean('is_published');

        DB::beginTransaction();
        try {
            $this->artworkService->updateArtwork($artwork, $validated);

            if ($request->hasFile('images')) {
                $this->imageUploadService->uploadMultipleImages($request->file('images'), $artwork->id);
            }

            DB::commit();

            return redirect()->route('admin.artworks.index')
                ->with('success', 'Твір успішно оновлено!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Artwork update failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Помилка при оновленні: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Artwork $artwork)
    {
        DB::beginTransaction();
        try {
            $this->imageUploadService->deleteArtworkImages($artwork);
            $this->artworkService->deleteArtwork($artwork);
            DB::commit();

            return redirect()->route('admin.artworks.index')
                ->with('success', 'Твір успішно видалено!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Artwork deletion failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Помилка при видаленні: ' . $e->getMessage());
        }
    }

    public function uploadImages(Request $request, Artwork $artwork): JsonResponse
    {
        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        try {
            $uploaded = $this->imageUploadService->uploadMultipleImages($request->file('images'), $artwork->id);

            return response()->json([
                'success' => true,
                'count'   => count($uploaded),
                'message' => 'Зображення завантажено',
            ]);
        } catch (\Exception $e) {
            Log::error('Images upload failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteImage(ArtworkImage $image): JsonResponse
    {
        try {
            $this->imageUploadService->deleteImage($image);

            return response()->json(['success' => true, 'message' => 'Зображення видалено']);
        } catch (\Exception $e) {
            Log::error('Delete image failed', ['image_id' => $image->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteImageById(int $id): JsonResponse
    {
        $image = ArtworkImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Зображення не знайдено'], 404);
        }

        return $this->deleteImage($image);
    }

    public function updateImagesOrder(Request $request, Artwork $artwork): JsonResponse
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'integer|exists:artwork_images,id',
        ]);

        try {
            $this->imageUploadService->updateImagesOrder($request->input('images'));

            return response()->json(['success' => true, 'message' => 'Порядок зображень оновлено']);
        } catch (\Exception $e) {
            Log::error('Update images order failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function setPrimaryImage(Request $request, Artwork $artwork): JsonResponse
    {
        $request->validate([
            'image_id' => 'required|integer|exists:artwork_images,id',
        ]);

        try {
            $this->imageUploadService->setPrimaryImage($request->input('image_id'), $artwork->id);

            return response()->json(['success' => true, 'message' => 'Головне зображення встановлено']);
        } catch (\Exception $e) {
            Log::error('Set primary image failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function togglePublished(Artwork $artwork): JsonResponse
    {
        try {
            $isPublished = $this->artworkService->togglePublished($artwork);
            $status      = $isPublished ? 'опубліковано' : 'знято з публікації';

            return response()->json([
                'success'      => true,
                'message'      => "Твір {$status}",
                'is_published' => $isPublished,
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle status failed', ['artwork_id' => $artwork->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Помилка при зміні статусу'], 500);
        }
    }
}
