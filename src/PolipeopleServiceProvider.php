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
            ->hasRoute('web')
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

        $this->publishes($publishArray, 'polipeople-translations');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/polipeople'),
        ], 'polipeople-scripts');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // Se il plugin pages è presente, registra il blocco
        if (class_exists(\Base33\Pages\PagesServiceProvider::class)) {
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'pages');

            \Base33\Pages\Resources\PageResource::registerBlock(
                \Detit\Polipeople\Resources\PageResource\Blocks\TeamList::make()
            );

            // Aggiungi il tipo di blocco all'array canOverlapTypes
            \Base33\Pages\Resources\PageResource::registerOverlappableBlock('polipeople-team-list');
        }

        // Validazione del tema
        $theme = config('polipeople.theme');

        // Se la configurazione non esiste, usa i valori di default
        if (!$theme) {
            $theme = [
                'use_default' => true,
                'theme' => 'default',
                'views_path' => 'themes.default.views.polipeople',
                'layout' => [
                    'default' => 'themes.default.layouts.default',
                    'team' => 'themes.default.layouts.team',
                ],
                'components' => [
                    'team_card' => 'themes.default.components.team-card',
                    'member_card' => 'themes.default.components.member-card',
                ],
            ];
        }

        if (!$theme['use_default']) {
            // Verifica che il tema esista
            $viewsPath = resource_path('views/themes/' . $theme['theme']);
            if (!file_exists($viewsPath)) {
                throw new \RuntimeException(
                    __('polipeople::messages.theme.not_found', ['theme' => $theme['theme']])
                );
            }

            // Verifica che i layout esistano
            foreach ($theme['layout'] as $key => $path) {
                $layoutPath = str_replace('themes.' . $theme['theme'], 'themes/' . $theme['theme'], $path);
                $fullPath = resource_path('views/' . str_replace('.', '/', $layoutPath) . '.blade.php');
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException(
                        __('polipeople::messages.theme.layout_not_found', ['path' => $path])
                    );
                }
            }

            // Verifica che i componenti esistano
            foreach ($theme['components'] as $key => $path) {
                $componentPath = str_replace('themes.' . $theme['theme'], 'themes/' . $theme['theme'], $path);
                $fullPath = resource_path('views/' . str_replace('.', '/', $componentPath) . '.blade.php');
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException(
                        __('polipeople::messages.theme.component_not_found', ['path' => $path])
                    );
                }
            }
        } else {
            // Se usa il tema di default, verifica che i file esistano nel plugin
            $basePath = __DIR__ . '/../resources/views/themes/default';

            // Verifica che i layout esistano
            foreach ($theme['layout'] as $key => $path) {
                $layoutPath = str_replace('themes.default', '', $path);
                $fullPath = $basePath . str_replace('.', '/', $layoutPath) . '.blade.php';
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException(
                        __('polipeople::messages.theme.layout_not_found', ['path' => $path])
                    );
                }
            }

            // Verifica che i componenti esistano
            foreach ($theme['components'] as $key => $path) {
                $componentPath = str_replace('themes.default', '', $path);
                $fullPath = $basePath . str_replace('.', '/', $componentPath) . '.blade.php';
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException(
                        __('polipeople::messages.theme.component_not_found', ['path' => $path])
                    );
                }
            }
        }

        // Registra il middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('localize-team-urls', \Detit\Polipeople\Http\Middleware\LocalizeTeamUrls::class);

        // Registra le rotte del plugin solo se non esistono quelle del tema
        $this->app->booted(function () {
            if (!Route::has('teams')) {
                Route::middleware(config('polipeople.middleware', ['web']))
                    ->name('polipeople.')
                    ->group(function () {
                        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                    });
            }
        });

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
    }
}
