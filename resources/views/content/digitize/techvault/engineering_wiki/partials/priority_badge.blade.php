@if ($priority === 'low')
    <span class="badge bg-success">Low</span>
@elseif($priority === 'medium')
    <span class="badge bg-info">Medium</span>
@elseif($priority === 'high')
    <span class="badge bg-warning">High</span>
@elseif($priority === 'critical')
    <span class="badge bg-danger">Critical</span>
@endif
