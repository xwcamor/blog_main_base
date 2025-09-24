<p>
  <strong><i class="fas fa-user"></i> {{ __('global.created_by') }}:</strong>
  {{ $tenant->creator->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-plus"></i> {{ __('global.created_at') }}:</strong>
  {{ formatDateTime($tenant->created_at) }}
</p>

@if ($tenant->trashed())
<hr>
<p>
  <strong><i class="fas fa-user-slash"></i> {{ __('global.deleted_by') }}:</strong>
  {{ $tenant->deleter->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-times"></i> {{ __('global.deleted_at') }}:</strong>
  {{ formatDateTime($tenant->deleted_at) }}
</p>

<p>
  <strong><i class="fas fa-comment-alt"></i> {{ __('global.deleted_reason') }}:</strong>
  {{ $tenant->deleted_description ?? '-' }}
</p>
@endif
