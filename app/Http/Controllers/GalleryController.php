<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        try {
            $featuredArtworks = collect();
            $recentArtworks = collect();
            $categories = collect();

            try {
                $featuredArtworks = Artwork::with(['user', 'categories'])
                    ->where('is_available', true)
                    ->take(8)
                    ->get();

                $categories = Category::take(10)->get();

                $recentArtworks = Artwork::with(['user', 'categories'])
                    ->where('is_available', true)
                    ->latest()
                    ->take(8)
                    ->get();
            } catch (\Exception $dbError) {
                \Log::warning('Database not ready: ' . $dbError->getMessage());
            }

            return view('gallery.index', compact(
                'featuredArtworks',
                'recentArtworks',
                'categories'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in GalleryController@index: ' . $e->getMessage());
            return response()->view('gallery.index', [
                'featuredArtworks' => collect(),
                'recentArtworks' => collect(),
                'categories' => collect()
            ]);
        }
    }

    public function show($slug)
    {
        try {
            $artwork = Artwork::with([
                'user',
                'categories',
                'comments' => function($query) {
                    $query->with('user')
                          ->where('is_approved', true)
                          ->latest();
                },
                'likes'
            ])
            ->where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();

            $relatedArtworks = Artwork::whereHas('categories', function($query) use ($artwork) {
                $query->whereIn('categories.id', $artwork->categories->pluck('id'));
            })
            ->where('id', '!=', $artwork->id)
            ->where('is_available', true)
            ->with(['user', 'categories'])
            ->withCount('likes')
            ->inRandomOrder()
            ->take(6)
            ->get();

            return view('gallery.show', [
                'artwork' => $artwork,
                'relatedArtworks' => $relatedArtworks,
                'title' => $artwork->title . ' | ' . config('app.name'),
                'description' => $artwork->description ?: __('app.gallery_artwork_by', ['name' => $artwork->user->name])
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in GalleryController@show: ' . $e->getMessage());
            return back()->with('error', __('app.gallery_artwork_not_found'));
        }
    }

    public function all(Request $request)
    {
        try {
            $query = Artwork::with(['user', 'categories'])
                ->where('is_available', true)
                ->withCount(['likes', 'comments']);

            if ($request->has('category')) {
                $query->whereHas('categories', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            $sortBy = $request->get('sort', 'newest');
            switch ($sortBy) {
                case 'likes':
                    $query->orderBy('likes_count', 'desc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }

            $artworks = $query->paginate(12);
            $categories = Category::withCount('artworks')->orderBy('name')->get();

            return view('gallery.artworks', [
                'artworks' => $artworks,
                'categories' => $categories,
                'title' => __('app.gallery_all_works'),
                'description' => __('app.gallery_all_description')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in GalleryController@all: ' . $e->getMessage());
            return back()->with('error', __('app.gallery_load_error'));
        }
    }

    public function category($slug, Request $request)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();

            $query = $category->artworks()
                ->with(['user', 'categories'])
                ->where('is_available', true)
                ->withCount('likes');

            $sortBy = $request->get('sort', 'newest');
            switch ($sortBy) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'likes':
                    $query->orderBy('likes_count', 'desc');
                    break;
                default:
                    $query->latest();
            }

            $artworks = $query->paginate(24);

            $categories = Category::withCount(['artworks' => function($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('name')
            ->get();

            return view('gallery.category', [
                'artworks' => $artworks,
                'category' => $category,
                'categories' => $categories,
                'title' => $category->name . ' | ' . config('app.name'),
                'description' => $category->description ?: __('app.gallery_category_works', ['name' => $category->name]),
                'sortBy' => $sortBy
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in GalleryController@category: ' . $e->getMessage());
            return back()->with('error', __('app.gallery_category_not_found'));
        }
    }
}
