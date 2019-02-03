<div class="page">
    <ul class="pagination">
        <li @if($meta['pagination']['current_page'] == 1)class="disabled"@endif>
            <span>«</span>
        </li>
        @for($i = 1; $i <= $meta['pagination']['total_pages']; $i++)
            @if($meta['pagination']['current_page'] == $i)
                <li class="active"><span>{{ $i }}</span></li>
            @else
                <li><a href="?page={{ $i }}">{{ $i }}</a></li>
            @endif
        @endfor
        <li @if($meta['pagination']['current_page'] == $meta['pagination']['total_pages'])class="disabled"@endif>
            <a href="?page={{ $meta['pagination']['current_page'] + 1 }}">»</a>
        </li>
    </ul>
</div>