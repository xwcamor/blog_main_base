<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('system_modules.export_title') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>{{ __('system_modules.export_title') }}</h2>

    <table>
        <thead>
            <tr>
                <th>{{ __('system_modules.id') }}</th>
                <th>{{ __('system_modules.name') }}</th>
                <th>{{ __('system_modules.is_active') }}</th>
                <th>{{ __('global.created_by') }}</th>
                <th>{{ __('global.created_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($languages as $i => $language)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $language->name }}</td>
                    <td>{{ $language->iso_code }}</td>
                    <td>{{ $language->state_text }}</td>
                    <td>{{ $language->creator->name ?? '-' }}</td>
                    <td>{{ formatDateTime($language->created_at) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
