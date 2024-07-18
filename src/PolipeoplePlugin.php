<?php

namespace Detit\Polipeople;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Detit\Polipeople\Resources\TeamResource;
use Detit\Polipeople\Resources\MemberResource;

class PolipeoplePlugin implements Plugin
{
    public function getId(): string
    {
        return 'polipeople';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                TeamResource::class,
                MemberResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
