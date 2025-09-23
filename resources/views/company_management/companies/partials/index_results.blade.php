<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>{{ __('companies.num_doc') }}</th>
            <th>{{ __('companies.name') }}</th>
            <th class="text-center">{{ __('global.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
        <tr>
            <td>{{ $company->num_doc }}</td>
            <td>{{ $company->name }}</td>
            <td class="text-center">
                <a class="btn btn-sm btn-info mr-1" href="{{ route('company_management.companies.show', $company->slug) }}" title="{{ __('global.view') }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-primary mr-1" href="{{ route('company_management.companies.edit', $company->slug) }}" title="{{ __('global.edit') }}">
                    <i class="fas fa-edit"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="{{ route('company_management.companies.delete', $company->slug) }}" title="{{ __('global.delete') }}">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $companies->links() }}
