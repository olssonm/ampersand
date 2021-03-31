<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="col-md-6 mx-auto">
            <h2 class="my-4">My blog</h2>
            <p>
                This is a simple template for displaying your posts. You may edit these in <code>/resources/views/vendor/ampersand</code> after installing the package via <code>php artisan vendor:publish --provider="Olssonm\Ampersand\AmpersandServiceProvider"</code>.
            </p>
            @foreach ($posts as $post)
                <div class="my-4">
                    <h2>{{ $post->title }}</h2>
                    <p>
                        <small class="text-muted">{{ $post->date }}</small>
                    </p>

                    <a href="{{ route('ampersand.show', $post) }}">Read post &#8594;</a>
                </div>
            @endforeach
            {{-- The $posts-variable is a paginator-instance --}}
            {{-- {!! $posts->links() !!} --}}
        </div>
    </div>
</body>
</html>
