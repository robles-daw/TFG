@if ($paginator->hasPages())
    <nav class="paginacion-contenedor" aria-label="Paginacion">
        <p class="paginacion-texto">
            Mostrando {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
            de {{ $paginator->total() }} resultados
        </p>

        <ul class="paginacion">
            @if ($paginator->onFirstPage())
                <li class="paginacion-item desactivado">
                    <span class="paginacion-boton" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="paginacion-item">
                    <a class="paginacion-boton" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Pagina anterior">&lsaquo;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="paginacion-item desactivado">
                        <span class="paginacion-boton">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <li class="paginacion-item activa" aria-current="page">
                                <span class="paginacion-boton">{{ $page }}</span>
                            </li>
                        @else
                            <li class="paginacion-item">
                                <a class="paginacion-boton" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="paginacion-item">
                    <a class="paginacion-boton" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Pagina siguiente">&rsaquo;</a>
                </li>
            @else
                <li class="paginacion-item desactivado">
                    <span class="paginacion-boton" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
