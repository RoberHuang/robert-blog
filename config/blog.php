<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/20
 * Time: 22:42
 */

return [
    'name' => env('APP_NAME', 'iBlog'),
    'title' => env('APP_NAME', 'iBlog'),
    'subtitle' => env('APP_URL', 'http://blog.com'),
    'url' => env('APP_URL', 'http://blog.com'),
    'posts_per_page' => 5,

    'seo_title' => 'This is Robert\'s blog',
    'keywords' => '',
    'description' => 'Rogue的博客',
    'author' => 'Robert',
    'email' => 'roberhuang@outlook.com',

    'copyright' => '@iblog',
    'web_count' => '2018',

    'uploads' => [
        'storage' => 'public',
        'webpath' => '/storage',
    ],

    'page_image' => '/storage/uploads/home-bg.jpg',
    'article_thumb' => '/images/article_thumb.jpg',

    'rss_size' => 10,
];