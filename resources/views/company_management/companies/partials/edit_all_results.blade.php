<table class="table table-hover">
    <thead class="bg-light">
        <tr>
            <th>
                <a class="text-dark text-decoration-none"
                   href="{{ route('company_management.companies.edit_all', array_merge(request()->all(), ['sort'=>'id','direction'=>request('direction')==='asc'?'desc':'asc'])) }}">
                   {{ __('companies.id') }}
                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none"
                   href="{{ route('company_management.companies.edit_all', array_merge(request()->all(), ['sort'=>'num_doc','direction'=>request('direction')==='asc'?'desc':'asc'])) }}">
                   {{ __('companies.num_doc') }}
                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none"
                   href="{{ route('company_management.companies.edit_all', array_merge(request()->all(), ['sort'=>'name','direction'=>request('direction')==='asc'?'desc':'asc'])) }}">
                   {{ __('companies.name') }}
                </a>
            </th>
            <th>{{ __('global.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
        <tr>
            <td>{{ $company->id }}</td>


            <td class="editable-cell" contenteditable="true"
                data-id="{{ $company->id }}"
                data-field="num_doc"
                data-original="{{ $company->num_doc }}">
                {{ $company->num_doc }}
            </td>

            <td class="editable-cell" contenteditable="true"
                data-id="{{ $company->id }}"
                data-field="name"
                data-original="{{ $company->name }}">
                {{ $company->name }}
            </td>

            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-light" href="{{ route('company_management.companies.show', $company) }}" title="{{ __('global.show') }}">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-light" href="{{ route('company_management.companies.edit', $company) }}" title="{{ __('global.edit') }}">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-light" href="{{ route('company_management.companies.delete', $company) }}" title="{{ __('global.delete') }}">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $companies->links() }}
</div>
