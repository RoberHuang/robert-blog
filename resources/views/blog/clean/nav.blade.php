<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <a class="navbar-brand" href="/">{{ config('blog.name') }}</a>
        <button class="navbar-toggle navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            导航菜单
            <i class="fas fa-bars"></i>
        </button>

        {{-- Collect the nav links, forms, and other content for toggling --}}
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/contact">联系我们</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="/">首页</a>
                </li>
            </ul>
        </div>
    </div>
</nav>