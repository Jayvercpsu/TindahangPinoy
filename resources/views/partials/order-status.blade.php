@php
    $colors = [
        'approved' => 'success',
        'pending' => 'warning text-dark',
        'in progress' => 'info',
        'delivered' => 'primary',
        'rejected' => 'danger',
        'canceled' => 'secondary',
    ];
@endphp

<span class="badge bg-{{ $colors[$status] ?? 'secondary' }}">
    {{ ucfirst($status) }}
</span>
