<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Assets Path
    |--------------------------------------------------------------------------
    |
    | This value determines the path that Livewire will use to serve its
    | internal JavaScript and CSS assets. If you are having issues
    | with 404's, you can try changing this to a different value.
    |
    */

    'asset_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire Update Endpoint
    |--------------------------------------------------------------------------
    |
    | This value determines the endpoint that Livewire will use to update
    | components. By default, this is set to "/livewire/update".
    |
    */

    'update_route_pattern' => '/livewire/update',

    /*
    |--------------------------------------------------------------------------
    | Inject Livewire Scripts/Styles Automatically
    |--------------------------------------------------------------------------
    |
    | Livewire 3 will automatically inject its scripts and styles.
    |
    */

    'inject_assets' => true,

    'navigate' => [
        'show_progress_bar' => true,
    ],

];
