@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <table class="pagination" style="white-space: nowrap; overflow-x: auto; width: 100%;">
            <tr>
                @if ($paginator->onFirstPage())
                    <td class="disabled" aria-disabled="true"><span>&laquo;</span></td>
                @else
                    <td><button type="button" wire:click="previousPage" rel="prev">&laquo;</button></td>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <td class="disabled" aria-disabled="true"><span>{{ $element }}</span></td>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <td class="active" aria-current="page"><span>{{ $page }}</span></td>
                            @else
                                <td><button type="button" wire:click="gotoPage({{ $page }})">{{ $page }}</button></td>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <td><button type="button" wire:click="nextPage" rel="next">&raquo;</button></td>
                @else
                    <td class="disabled" aria-disabled="true"><span>&raquo;</span></td>
                @endif
            </tr>
        </table>
    </div>
@endif
<style>
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        overflow-x: auto;
    }

    .pagination {
        white-space: nowrap;
    }

    .pagination td {
        padding: 5px;
    }

    @media (min-width: 768px) and (max-width: 1023px) {
        /* Styles pour les tablettes */
        .pagination td {
            padding: 8px;
        }
    }

    @media (max-width: 767px) {
        /* Styles pour les appareils mobiles */
        .pagination-wrapper {
            display: block;
            overflow-x: auto;
        }

        .pagination td {
            display: block;
            text-align: center;
            margin-bottom: 5px;
        }
    }
</style>
