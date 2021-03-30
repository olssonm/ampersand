<?php

return [
    'posts_path' => base_path('posts'),

    'url' => 'blog',

    'per_page' => 10,

    'page_indicator' => 'page',

    /**
     * Register the ampersand.index and ampersand.show-routes
     * within the default web-middleware
     */
    'register_routes' => true
];
