<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Services\Interfaces\Artwork\ArtworkServiceInterface;
use App\Services\Implementations\Artwork\ArtworkService;
use App\Services\Interfaces\Auth\AuthServiceInterface;
use App\Services\Implementations\Auth\AuthService;

class AppServiceProvider extends ServiceProvider
{
    // биндинг сервисов
    public function register(): void
    {
        $this->app->bind(ArtworkServiceInterface::class, ArtworkService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        // фикс для докера
        $tmpBase = sys_get_temp_dir() . '/katrin_gallery_storage';

        foreach ([
            $tmpBase . '/framework/cache/data',
            $tmpBase . '/framework/sessions',
            $tmpBase . '/framework/views',
            $tmpBase . '/logs',
        ] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        Config::set('cache.default', 'file');
        Config::set('cache.stores.file.path', $tmpBase . '/framework/cache/data');
        Config::set('view.compiled', $tmpBase . '/framework/views');
        Config::set('session.driver', 'file');
        Config::set('session.files', $tmpBase . '/framework/sessions');
        Config::set('logging.channels.single.path', $tmpBase . '/logs/laravel.log');
        Config::set('logging.channels.daily.path', $tmpBase . '/logs/laravel.log');
    }

    public function boot(): void {}
}
