<!-- Navigation Menu -->
<div class="nav-align-top mb-4">
    <ul class="nav nav-pills flex-column flex-md-row gap-2 gap-lg-0">

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('monitoring/analysis/energy') ? 'active' : '' }}"
                href="{{ url('monitoring/analysis/energy') }}">
                <i class="ti-sm ti ti-bolt me-1_5"></i> Energy
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('monitoring/analysis/realtime') ? 'active' : '' }}"
                href="{{ url('monitoring/analysis/realtime') }}">
                <i class="ti-sm ti ti-activity me-1_5"></i> Realtime
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('monitoring/analysis/powerquality') ? 'active' : '' }}"
                href="{{ url('monitoring/analysis/powerquality') }}">
                <i class="ti-sm ti ti-chart-line me-1_5"></i> Power Quality
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('monitoring/analysis/heatmap') ? 'active' : '' }}"
                href="{{ url('monitoring/analysis/heatmap') }}">
                <i class="ti-sm ti ti-flame me-1_5"></i> Heatmap
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('monitoring/analysis/demand') ? 'active' : '' }}"
                href="{{ url('monitoring/analysis/demand') }}">
                <i class="ti-sm ti ti-trending-up me-1_5"></i> Demand
            </a>
        </li>

    </ul>
</div>
