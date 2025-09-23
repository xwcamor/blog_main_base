<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('regions.pdf_title') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('regions.pdf_title') }}</h1>
        <p>{{ __('global.generated_at') }}: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>{{ __('regions.id') }}</th>
                <th>{{ __('regions.name') }}</th>
                <th>{{ __('regions.is_active') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($regions as $region)
            <tr>
                <td>{{ $region->id }}</td>
                <td>{{ $region->name }}</td>
                <td>{{ $region->state_text }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ __('global.page') }} <span class="page"></span> {{ __('global.of') }} <span class="topage"></span></p>
    </div>
</body>
</html>
