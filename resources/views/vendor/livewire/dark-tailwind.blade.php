@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-500 bg-[#0f172a]/40 border border-white/10 cursor-default leading-5 rounded-md">
                            Previous
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#0f172a]/40 border border-white/10 leading-5 rounded-md hover:bg-[#036482]/20 hover:border-[#036482]/50 focus:outline-none focus:ring-2 focus:ring-[#036482] focus:border-[#036482] active:bg-[#036482]/30 transition ease-in-out duration-150">
                            Previous
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-[#0f172a]/40 border border-white/10 leading-5 rounded-md hover:bg-[#036482]/20 hover:border-[#036482]/50 focus:outline-none focus:ring-2 focus:ring-[#036482] focus:border-[#036482] active:bg-[#036482]/30 transition ease-in-out duration-150">
                            Next
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-slate-500 bg-[#0f172a]/40 border border-white/10 cursor-default leading-5 rounded-md">
                            Next
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-slate-400 leading-5">
                        Showing
                        <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium text-white">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex gap-2 rounded-md">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="Previous">
                                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-500 bg-[#0f172a]/40 border border-white/10 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @else
                                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-[#0f172a]/40 border border-white/10 rounded-l-md leading-5 hover:bg-[#036482]/20 hover:border-[#036482]/50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-[#036482] focus:border-[#036482] active:bg-[#036482]/30 transition ease-in-out duration-150" aria-label="Previous">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-500 bg-[#0f172a]/40 border border-white/10 cursor-default leading-5">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-gradient-to-r from-[#036482] to-[#036482]/80 border border-[#036482] cursor-default leading-5 shadow-lg shadow-[#036482]/20">{{ $page }}</span>
                                            </span>
                                        @else
                                            <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-[#0f172a]/40 border border-white/10 leading-5 hover:bg-[#036482]/20 hover:border-[#036482]/50 hover:text-white focus:z-10 focus:outline-none focus:ring-2 focus:ring-[#036482] focus:border-[#036482] active:bg-[#036482]/30 transition ease-in-out duration-150" aria-label="Go to page {{ $page }}">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-white bg-[#0f172a]/40 border border-white/10 rounded-r-md leading-5 hover:bg-[#036482]/20 hover:border-[#036482]/50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-[#036482] focus:border-[#036482] active:bg-[#036482]/30 transition ease-in-out duration-150" aria-label="Next">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="Next">
                                    <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-slate-500 bg-[#0f172a]/40 border border-white/10 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
