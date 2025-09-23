<p>
    <strong><i class="fas fa-user"></i> {{ __('global.created_by') }}:</strong>
    {{ $company->creator->name ?? '-' }}
</p>

<p>
    <strong><i class="fas fa-calendar-plus"></i> {{ __('global.created_at') }}:</strong>
    {{ formatDateTime($company->created_at) }}
</p>

@if ($company->trashed())
<hr>
<p>
    <strong><i class="fas fa-user-slash"></i> {{ __('global.deleted_by') }}:</strong>
    {{ $company->deleter->name ?? '-' }}
</p>

<p>
    <strong><i class="fas fa-calendar-times"></i> {{ __('global.deleted_at') }}:</strong>
    {{ formatDateTime($company->deleted_at) }}
</p>

<p>
    <strong><i class="fas fa-comment-alt"></i> {{ __('global.deleted_reason') }}:</strong>
    {{ $company->deleted_description ?? '-' }}
</p>
@endif
