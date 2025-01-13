<?php

namespace Detit\Polipeople\Commands;

use Illuminate\Console\Command;

class VerifyThemeCommand extends Command
{
    protected $signature = 'polipeople:verify-theme';
    protected $description = 'Verifica che il tema configurato in polipeople.php esista e sia valido';

    public function handle()
    {
        try {
            $theme = config('polipeople.theme');
            if ($theme['use_default']) {
                $this->info('✓ Usando il tema di default');
                return;
            }

            $this->info("Verifico il tema '{$theme['theme']}'...");

            // Verifica cartella tema
            $viewsPath = resource_path('views/themes/' . $theme['theme']);
            if (!file_exists($viewsPath)) {
                throw new \RuntimeException("La cartella del tema non esiste in {$viewsPath}");
            }
            $this->info('✓ Cartella tema trovata');

            // Verifica layout
            foreach ($theme['layout'] as $key => $path) {
                $layoutPath = str_replace('themes.' . $theme['theme'], 'themes/' . $theme['theme'], $path);
                $fullPath = resource_path('views/' . str_replace('.', '/', $layoutPath) . '.blade.php');
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException("Layout '{$path}' non trovato in {$fullPath}");
                }
            }
            $this->info('✓ Layout verificati');

            // Verifica componenti
            foreach ($theme['components'] as $key => $path) {
                $componentPath = str_replace('themes.' . $theme['theme'], 'themes/' . $theme['theme'], $path);
                $fullPath = resource_path('views/' . str_replace('.', '/', $componentPath) . '.blade.php');
                if (!file_exists($fullPath)) {
                    throw new \RuntimeException("Componente '{$path}' non trovato in {$fullPath}");
                }
            }
            $this->info('✓ Componenti verificati');

            $this->info('Tema verificato con successo!');

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
