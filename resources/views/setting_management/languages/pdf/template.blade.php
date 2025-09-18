<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('languages.pdf_title') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('languages.pdf_title') }}</h1>
        <p>{{ __('languages.pdf_subtitle') }} {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="table-container">
        @if($languages->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('languages.id') }}</th>
                        <th>{{ __('languages.name') }}</th>
                        <th>{{ __('languages.is_active') }}</th>
                        <th>{{ __('global.created_at') }}</th>
                        <th>{{ __('global.created_by') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($languages as $language)
                        <tr>
                            <td>{{ $language->id }}</td>
                            <td>{{ $language->name }}</td>
                            <td>
                                @if($language->is_active)
                                    <span class="status-active">{{ __('languages.status_options.active') }}</span>
                                @else
                                    <span class="status-inactive">{{ __('languages.status_options.inactive') }}</span>
                                @endif
                            </td>
                            <td>{{ $language->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $language->creator->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                {{ __('global.no_data') }}
            </div>
        @endif
    </div>

    <div class="footer">
        <p>{{ __('global.generated_by') }} {{ auth()->user()->name ?? 'Sistema' }} | {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>