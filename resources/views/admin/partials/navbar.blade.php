<ul class="nav navbar-nav">
    <li class="nav-item"><a class="nav-link" href="/">首页</a></li>
    @auth('admin')
        <li @if (Request::is('admin/post*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/article">文章</a>
        </li>
        <li @if (Request::is('admin/cate*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/categories">分类</a>
        </li>
        <li @if (Request::is('admin/tag*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/tag">标签</a>
        </li>
        <li @if (Request::is('admin/upload*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/upload">上传</a>
        </li>
        <li @if (Request::is('admin/config*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/config">配置</a>
        </li>
    @endauth
</ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
    <!-- Authentication Links -->
    {{--@guest--}}
    @if (auth()->guard('admin')->guest())
        <li><a href="{{ route('admin.login') }}">Login</a></li>
        {{--<li><a href="{{ route('admin.register') }}">Register</a></li>--}}
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @endif
    {{--@endguest--}}
</ul>