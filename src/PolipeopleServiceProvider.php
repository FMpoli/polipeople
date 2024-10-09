<?php

namespace Detit\Polipeople;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Detit\Polipeople\Commands\PolipeopleCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Illuminate\Support\Facades\Route;
class PolipeopleServiceProvider extends PackageServiceProvider
{
    public static string $name = 'polipeople';

    public static string $viewNamespace = 'polipeople';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasRoute('web')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ;
            });

        $configFileName = $package->shortName();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'polipeople');

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('polipeople.route_prefix', ''),
            'middleware' => config('polipeople.middleware', ['web']),
        ];
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/polipeople/{$file->getFilename()}"),
                ], 'polipeople-stubs');
            }
        }

        // Testing
        // Testable::mixin(new TestsPolipeople());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'detit/polipeople';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('polipeople', __DIR__ . '/../resources/dist/components/polipeople.js'),
            Css::make('polipeople-styles', __DIR__ . '/../resources/dist/polipeople.css'),
            Js::make('polipeople-scripts', __DIR__ . '/../resources/dist/polipeople.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PolipeopleCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_polipeople_teams_table',
            'create_polipeople_members_table',
            'create_polipeople_teams_members_table',
            'update_polipeople_members_table',
        ];
    }
}
