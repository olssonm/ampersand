<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="col-md-6 mx-auto">
            <h2 class="my-4">{{ $post->title }}</h2>
            <p>
                <small class="text-muted">{{ $post->date }}</small>
            </p>
            {!! $post->contents !!}
            <div class="mt-4">
                <a href="{{ route('ampersand.index') }}">&#8592; Back to index</a>
            </div>
        </div>
    </div>
</body>
</html>
