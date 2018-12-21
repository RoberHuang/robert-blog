<html>
<head>
    <title>{{ config('blog.title') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>{{ config('blog.title') }}</h1>
    <h5>Page {{ $articles->currentPage() }} of {{ $articles->lastPage() }}</h5>
    <hr>
    <ul>
        @foreach($articles as $article)
            <li>
                <a href="{{ route('blog.detail', ['slug' => $article->slug]) }}">{{ $article->article_title }}</a>

                <em>({{ $article->published_at }})</em>
                <p>
                    {{ str_limit($article->article_content) }}
                </p>
            </li>
        @endforeach
    </ul>
    <hr>
    {!! $articles->render() !!}
</div>
</body>
</html>