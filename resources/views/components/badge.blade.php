@if (!isset($show) || $show) {{-- default true (in case $show is not passed) --}}
    <span class="badge badge-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif
