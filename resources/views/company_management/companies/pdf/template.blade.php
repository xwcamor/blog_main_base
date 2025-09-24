<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('companies.export_title') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>{{ __('companies.export_title') }}</h2>

    <table>
        <thead>
            <tr>
                <th>{{ __('companies.id') }}</th>
                <th>{{ __('companies.ruc') }}</th>
                <th>{{ __('companies.razon_social') }}</th>
                <th>{{ __('companies.direccion') }}</th>
                <th>{{ __('companies.num_doc') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $i => $company)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $company->ruc }}</td>
                    <td>{{ $company->razon_social }}</td>
                    <td>{{ $company->direccion }}</td>
                    <td>{{ $company->num_doc }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>