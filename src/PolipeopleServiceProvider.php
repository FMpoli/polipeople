<?php

namespace Detit\Polipeople;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Detit\Polipeople\Commands\VerifyThemeCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Detit\Polipeople\Commands\PolipeopleCommand;

class PolipeopleServiceProvider extends PackageServiceProvider
{
    public static string $name = 'polipeople';
    public static string $viewNamespace = 'polipeople';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasTranslations()
            ->hasViews()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();
            });

        // Registra il config come pubblicabile
        $this->publishes([
            __DIR__.'/../config/polipeople.php' => config_path('polipeople.php'),
        ], 'polipeople-config');

        // Registra le viste come pubblicabili
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/polipeople'),
            __DIR__.'/../resources/views/themes/default' => resource_path('views/themes/default'),
        ], 'polipeople-views');

        // Registra le traduzioni come pubblicabili
        $langPath = __DIR__.'/../resources/lang';
        $publishArray = [];

        // Pubblica ogni lingua separatamente
        foreach (glob($langPath . '/*', GLOB_ONLYDIR) as $langDir) {
            $lang = basename($langDir);
            $publishArray[$langDir] = base_path("lang/vendor/polipeople/{$lang}");
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        $this->publishes($publishArray, 'polipeople-translations');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/polipeople'),
        ], 'polipeople-scripts');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // Se il plugin pages è presente, registra i blocchi
        if (class_exists(\Base33\Pages\PagesServiceProvider::class)) {
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'pages');

            // Registra i blocchi
            \Base33\Pages\Resources\PageResource::registerBlock(
                \Detit\Polipeople\Resources\PageResource\Blocks\TeamList::make()
            );

            \Base33\Pages\Resources\PageResource::registerBlock(
                \Detit\Polipeople\Resources\PageResource\Blocks\MemberDetail::make()
            );

        }

        // Register components
        Blade::component('polipeople::components.team-list', 'polipeople::team-list');
        Blade::component('polipeople::components.member-card', 'polipeople::member-card');
    }

    protected function getCommands(): array
    {
        return [
            PolipeopleCommand::class,
            VerifyThemeCommand::class,
        ];
    }

    protected function getMigrations(): array
    {
        return [
            'create_polipeople_teams_table',
            'create_polipeople_members_table',
            'create_polipeople_teams_members_table',
            'update_polipeople_members_table',
        ];
    }

    public function boot()
    {
        parent::boot();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
