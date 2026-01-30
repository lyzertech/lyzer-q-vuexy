@if ($status === 'open')
    <span class="badge bg-primary">Open</span>
@elseif($status === 'monitoring')
    <span class="badge bg-warning">Monitoring</span>
@elseif($status === 'solved')
    <span class="badge bg-success">Solved</span>
@elseif($status === 'closed')
    <span class="badge bg-secondary">Closed</span>
@endif
