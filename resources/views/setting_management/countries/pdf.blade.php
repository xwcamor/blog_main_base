<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('countries.plural') }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('countries.plural') }}</h1>
        <p>{{ __('global.app_name') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>{{ __('global.id') }}</th>
                <th>{{ __('global.name') }}</th>
                <th>{{ __('global.status') }}</th>
                <th>{{ __('global.created_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->is_active ? __('global.active') : __('global.inactive') }}</td>
                    <td>{{ $country->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ __('global.app_name') }}. All rights reserved.</p>
    </div>
</body>
</html>
