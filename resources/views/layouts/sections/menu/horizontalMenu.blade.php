@php
    use Illuminate\Support\Facades\Route;
    $configData = Helper::appClasses();
@endphp
<!-- Horizontal Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
    <div class="{{ $containerNav }} d-flex h-100">
        <ul class="menu-inner pb-2 pb-xl-0">
            {{-- this HorizontalMenu still using verticalMenu.json --}}
            @php
                if (request()->is('monitoring/*')) {
                    $menusToDisplay = $menuData[0]->menuMonitoring;
                } elseif (auth()->user()->role_id == '1') {
                    $menusToDisplay = $menuData[0]->menuAdmin;
                } elseif (auth()->user()->role_id == '11') {
                    $menusToDisplay = $menuData[0]->menuFamilia;
                } else {
                    $menusToDisplay = $menuData[0]->menu;
                }
            @endphp

            @foreach ($menusToDisplay as $menu)
                {{-- adding active and open class if child is active --}}

                {{-- menu headers --}}
                @if (isset($menu->menuHeader))
                    <li class="menu-header small">
                        <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                    </li>
                @else
                    {{-- active menu method --}}
                    @php
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();

                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (gettype($menu->slug) === 'array') {
                                foreach ($menu->slug as $slug) {
                                    if (
                                        str_contains($currentRouteName, $slug) and
                                        strpos($currentRouteName, $slug) === 0
                                    ) {
                                        $activeClass = 'active open';
                                    }
                                }
                            } else {
                                if (
                                    str_contains($currentRouteName, $menu->slug) and
                                    strpos($currentRouteName, $menu->slug) === 0
                                ) {
                                    $activeClass = 'active open';
                                }
                            }
                        }
                    @endphp

                    {{-- main menu --}}
                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                            @isset($menu->badge)
                                <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                            @endisset
                        </a>

                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
<!--/ Horizontal Menu -->
