@if (count ($breadcrumbs))
    {{-- Breadcrumbs --}}
    <nav class="mb-4" aria-label="Breadcrumb">
        <ol class="flex flex-wrap text-sm text-slate-700">
            @foreach ($breadcrumbs as $item)
                <li
                    class="leading-normal {{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/']" : '' }}">
                    @if (isset($item['route']))
                        <a href="{{ $item['route'] }}" class="hover:underline opacity-70">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="font-semibold text-gray-500">
                            {{ $item['name'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
    </nav>
@endif
