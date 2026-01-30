@php
    use Illuminate\Support\Facades\Route;
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            {{-- <a href="{{ url('/') }}" class="app-brand-link"> --}}
            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
            <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            {{-- </a> --}}

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
            </a>
        </div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- @php
            $menusToDisplay = auth()->user()->role_id == '1' ? $menuData[0]->menuAdmin : $menuData[0]->menu;
        @endphp --}}

        @php
            if (request()->is('monitoring/*')) {
                $menusToDisplay = $menuData[0]->menuMonitoring;
            } elseif (auth()->user()->role_id == '1') {
                $menusToDisplay = $menuData[0]->menuAdmin;
            } elseif (auth()->user()->role_id == '6') {
                $menusToDisplay = $menuData[0]->labs;
            } elseif (auth()->user()->role_id == '7') {
                $menusToDisplay = $menuData[0]->menuMonitoring;
            } elseif (auth()->user()->role_id == '11') {
                $menusToDisplay = $menuData[0]->menuFamilia;
            } elseif (auth()->user()->role_id == '21') {
                $menusToDisplay = $menuData[0]->menuSchTeacher;
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

                    // General: support relatedRoutes array in menu data
                    if (isset($menu->relatedRoutes) && is_array($menu->relatedRoutes)) {
                        if (in_array($currentRouteName, $menu->relatedRoutes)) {
                            $activeClass = 'active';
                        }
                    }
                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
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

</aside>
