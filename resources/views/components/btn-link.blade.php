@props(['class', 'icon' => 'bi bi-house'])

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
