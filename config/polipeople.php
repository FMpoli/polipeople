<?php

return [
    // Middleware per le route del plugin
    'middleware' => ['web'],

    // Theme configuration
    'theme' => [
        // Se true, usa il tema di default del plugin
        // Se false, usa il tema specificato
        'use_default' => false,

        // Nome del tema (se use_default è false)
        'theme' => 'photonext',

        // Path delle viste del tema
        'views_path' => 'themes.default.views.polipeople',

        // Layout paths
        'layout' => [
            'default' => 'themes.default.layouts.default',
            'team' => 'themes.default.layouts.team',
        ],

        // Componenti del tema
        'components' => [
            'team_card' => 'themes.default.components.team-card',
            'member_card' => 'themes.default.components.member-card',
        ],
    ],
];
