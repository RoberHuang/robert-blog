<html>
<head>
    <title>{{ $article->article_title }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>{{ $article->article_title }}</h1>
    <h5>{{ $article->published_at }}</h5>
    <hr>
    {!! nl2br(e($article->article_content)) !!}
    <hr>
    <button class="btn btn-primary" onclick="history.go(-1)">
        « Back
    </button>
</div>
</body>
</html>