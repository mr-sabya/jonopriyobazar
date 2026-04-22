@if($sortField !== $field)
    <i class="fas fa-sort text-muted opacity-25 float-end"></i>
@elseif($sortDirection === 'asc')
    <i class="fas fa-sort-up text-primary float-end"></i>
@else
    <i class="fas fa-sort-down text-primary float-end"></i>
@endif