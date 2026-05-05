<?php

namespace App\Services\Interfaces\Artwork;

use App\Models\Artwork;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

// с доки ларавел
interface ArtworkServiceInterface
{
    public function getAllArtworks(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function getArtworkById(int $id): Artwork;

    public function getArtworkBySlug(string $slug): Artwork;

    public function createArtwork(array $data, ?UploadedFile $image = null): Artwork;

    public function updateArtwork(Artwork|int $artwork, array $data, ?UploadedFile $image = null): Artwork;

    public function deleteArtwork(Artwork|int $artwork): bool;

    public function getArtworksByCategory(int $categoryId, int $perPage = 15): LengthAwarePaginator;

    public function getFeaturedArtworks(int $limit = 8): Collection;

    public function searchArtworks(string $query, int $perPage = 15): LengthAwarePaginator;

    public function getPopularArtworks(int $limit = 10): Collection;

    public function getRecentArtworks(int $limit = 10): Collection;

    public function getUserArtworks(int $userId, int $perPage = 15, bool $includeUnpublished = false): LengthAwarePaginator;

    public function toggleFeatured(Artwork $artwork): bool;

    public function togglePublished(Artwork $artwork): bool;

    public function bulkUpdatePublishStatus(array $artworkIds, bool $isPublished): int;

    public function getRelatedArtworks(Artwork $artwork, int $limit = 4): Collection;

    public function getArtworkStats(): array;
}
