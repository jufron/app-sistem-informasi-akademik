@props([
    'icon' => 'fas fa-th-list',
    'title',
    'id',
    'routes' => [],
    'items' => []
])

@php
    $isActive = collect($routes)->some(fn($route) => request()->routeIs($route));
@endphp

<li @class(['nav-item', 'active submenu' => $isActive])>
    <a data-bs-toggle="collapse" href="#{{ $id }}">
        <i class="{{ $icon }}"></i>
        <p>{{ $title }}</p>
        <span class="caret"></span>
    </a>
    <div @class(['collapse', 'show' => $isActive]) id="{{ $id }}">
        <ul class="nav nav-collapse">
            @foreach ($items as $item)
                <li @class(['active' => collect($item['routes'])->some(fn($r) => request()->routeIs($r))])>
                    <a href="{{ route($item['route']) }}">
                        <span class="sub-item">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
