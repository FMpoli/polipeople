<?php

namespace Detit\Polipeople\Commands;

use Illuminate\Console\Command;

class PolipeopleCommand extends Command
{
    protected $signature = 'polipeople
                            {action : The action to perform (install, publish-views, publish-config)}
                            {--force : Force the operation to run when publishing views}';

    protected $description = 'Manage Polipeople plugin';

    public function handle(): int
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'install':
                return $this->installPolipeople();
            case 'publish-views':
                return $this->publishViews();
            case 'publish-config':
                return $this->publishConfig();
            case 'publish-translations':
                return $this->publishTranslations();
            default:
                $this->error("Invalid action. Use 'install', 'publish-views', or 'publish-config'.");
                return self::FAILURE;
        }
    }

    protected function installPolipeople(): int
    {
        $this->info('Installing Polipeople...');

        // Publish migration files
        $this->call('vendor:publish', [
            '--tag' => 'polipeople-migrations'
        ]);

        // Run migrations
        $this->call('migrate', ['--path' => 'vendor/detit/polipeople/database/migrations']);

        // Publish config
        $this->call('vendor:publish', [
            '--provider' => 'Detit\Polipeople\PolipeopleServiceProvider',
            '--tag' => 'polipeople-config'
        ]);

        $this->info('Polipeople has been installed successfully!');
        $this->info('You can now publish the views if you want to customize them.');
        return self::SUCCESS;
    }

    protected function publishViews(): int
    {
        $this->info('Publishing Polipeople views...');

        $params = [
            '--provider' => 'Detit\Polipeople\PolipeopleServiceProvider',
            '--tag' => 'polipeople-views'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);

        $this->info('Polipeople views have been published successfully!');
        return self::SUCCESS;
    }

    protected function publishConfig(): int
    {
        $this->info('Publishing Polipeople config...');

        $this->call('vendor:publish', [
            '--provider' => 'Detit\Polipeople\PolipeopleServiceProvider',
            '--tag' => 'polipeople-config'
        ]);

        $this->info('Polipeople config has been published successfully!');
        return self::SUCCESS;
    }

    protected function publishTranslations(): int
    {
        $this->info('Publishing Polipeople translations...');

        $this->call('vendor:publish', [
            '--provider' => 'Detit\Polipeople\PolipeopleServiceProvider',
            '--tag' => 'polipeople-translations'
        ]);

        $this->info('Polipeople translations have been published successfully!');
        return self::SUCCESS;
    }
}
