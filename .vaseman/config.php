<?php
/**
 * Part of Vaseman project.
 *
 * @copyright  Copyright (C) 2018 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

return [
    'project' => [
        'name' => 'Windwalker'
    ],

    // Which folders you want to generate (Array)
    'folders' => [
        'entries' => '',
        'asset' => 'asset'
    ],

    // Plugin classes with namespace (Array)
    'plugins' => [
        \Vaseman\Plugin\MenuPlugin::class
    ],

    'system' => [
        'debug' => 0,
        'timezone' => 'UTC',
        'error_reporting' => -1,
    ],
];
