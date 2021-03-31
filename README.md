<p align="center"><img src="https://user-images.githubusercontent.com/907114/113181484-20c9c600-9252-11eb-9e13-7c361f4f5134.png" width="120px" alt="Ampersand – Blogging for Laravel" /></p>

<p align="center">
    <a href="https://packagist.org/packages/olssonm/ampersand">
        <img src="https://img.shields.io/packagist/v/olssonm/ampersand.svg?style=flat-square" alt="Latest Version on Packagist">
    </a>
    <a href="https://packagist.org/packages/olssonm/ampersand">
        <img src="https://img.shields.io/packagist/php-v/olssonm/ampersand?style=flat-square" alt="Supported PHP-versions">
    </a>
    <a href="LICENSE.md">
        <img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License">
    </a>
    <a href="https://github.com/olssonm/ampersand/actions?query=workflow%3A%22Run+tests%22">
        <img src="https://img.shields.io/github/workflow/status/olssonm/ampersand/Run%20tests.svg?style=flat-square&label=tests" alt="Build Status">
    </a>
</p>

# Ampersand

Plug-and-play flat file markdown blog tool for your Laravel-project. Perfect for when you want to have an article/blog-section on your site withough the hassle of setting up tables, models or your own flat file-system.

Built upon [spatie/sheets](https://github.com/spatie/sheets) to handle the markdown-files and YAML-front matter parsing.

*Note: This package is built for quick and easy setup and use – don't expect a fully featured CMS.*

## Install and configure

Require package:

```
$ composer require olssonm/ampersand
```

Publish config-files and views:

```
$ php artisan vendor:publish --provider="Olssonm\Ampersand\AmpersandServiceProvider"
```

In `config/ampersand.php` you can now customize the settings to your liking. Views are available at `resources/views/vendor/ampersand`

## Writing posts

### Filename format

All posts should be stores in your `posts_path`-directory with the filename format of `2021-03-30.my-post.md`, i.e. `{date:Y-m-d}.{slug}.md`.

The slug is what determins at what URL your post will be available at.

### Artisan command

You can quickly create a new post via the artisan command:

```
php artisan ampersand:new
```

### YAML front matter

Posts can contain any number of attributes via YAML-front matter:

```
---
title: This is a new post
date: '2020-01-01 20:00:01'
cover: https://amazingimages.com/my-cover.jpg
---

My post
```

## Displaying posts

Two views are shipped with this package; nd index-view and a show-view (used for single posts). They are located in `/resources/vendor/views/ampersand` after installation and are fully customizable.

In `index.blade.php` a collection of post-objects is available via the `$posts`-variable. It behaves much as a standard Eloquent-collection.

``` php
@foreach ($posts as $post)
    <h2>{{ $post->title }}</h2>
    <div>
        {!! $post->contents !!}
    </div>
@endforeach
```

Pagination-links are also available:

```
{{ $posts->links() }}
```

The Post-object contains all your front matter attributes as well as `slug`, `date` and `content`.

``` php
{{ $post->slug }} // my-post
{{ $post->date->format('Y-m-d') }} // 2021-03-30
{{ $post->contents }} // <p>My post</p>
{{ $post->cover }} // https://amazingimages.com/my-cover.jpg
```

## Defining your own routes

The default routes are registered withing the ampersand-name and the default web-middleware.

If you by any reason want to override this (for example if you want to have your articles behind a login or the like), you may set `register_routes` to `false` in ampersand.php, and then register them yourself:

``` php
use Olssonm\Ampersand\Http\Controllers\PostController;

Route::group(['middleware' => 'can:read', function() {
    Route::get('/articles', [PostController::class, 'index'])->name('article.index');
    Route::get('/articles/{post}', [PostController::class, 'show'])->name('article.show');
}]);
```

## License

The MIT License (MIT). Please see the [LICENSE.md](LICENSE.md) for more information.

© 2021 [Marcus Olsson](https://marcusolsson.me).
