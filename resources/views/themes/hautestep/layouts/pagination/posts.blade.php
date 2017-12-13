@if ($paginator->lastPage() > 1)
<ul class="pagination">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ ($paginator->currentPage() == 1) ? "#" : $paginator->url(1) }}">&laquo;</a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $paginator->url($i) }}&q={{ str_replace(" ","+",trim($request->get("q"))) }}">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? "#" : $paginator->url($paginator->currentPage()+1) }}" >&raquo;</a>
    </li>
</ul>
@endif