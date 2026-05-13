@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display: flex; justify-content: center; align-items: center; margin-top: 1rem;">
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; color: #999; cursor: default;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; text-decoration: none; color: #78350f;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; color: #999;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #78350f; background-color: #78350f; color: white; cursor: default;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; text-decoration: none; color: #78350f;">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; text-decoration: none; color: #78350f;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; color: #999; cursor: default;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
