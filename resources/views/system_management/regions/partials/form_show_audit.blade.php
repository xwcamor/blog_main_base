<p>
  <strong><i class="fas fa-user"></i> {{ __('global.created_by') }}:</strong>
  {{ $region->creator->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-plus"></i> {{ __('global.created_at') }}:</strong>
  {{ formatDateTime($region->created_at) }}
</p>

@if ($region->trashed())
<hr>
<p>
  <strong><i class="fas fa-user-slash"></i> {{ __('global.deleted_by') }}:</strong>
  {{ $region->deleter->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-times"></i> {{ __('global.deleted_at') }}:</strong>
  {{ formatDateTime($region->deleted_at) }}
</p>

<p>
  <strong><i class="fas fa-comment-alt"></i> {{ __('global.deleted_reason') }}:</strong>
  {{ $region->deleted_description ?? '-' }}
</p>
@endif
