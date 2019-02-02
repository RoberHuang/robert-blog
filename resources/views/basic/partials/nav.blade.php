<nav class="navbar navbar-default" role="navigation" style="margin-bottom:0">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#blog-navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}" style="padding: 5px 15px;">
                <img src="/images/basic/uploads/logo.jpg" class="img-responsive">
            </a>
        </div>
        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
        <div class="collapse navbar-collapse" id="blog-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
                <li><a href="/contacts"><span class="glyphicon glyphicon-envelope"></span> 联系我们</a></li>
            </ul>
        </div>

    </div>
</nav>
