<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Podziękowania</title>
    <style>
        @include('acknowledgements._print-styles')

        body {
            padding: 0;
        }

        .page {
            padding: 60px;
            page-break-after: always;
            break-after: page;
        }

        .page:last-child {
            page-break-after: auto;
            break-after: auto;
        }
    </style>
</head>
<body>
    @foreach ($contents as $content)
        <div class="page">
            {!! $content !!}
        </div>
    @endforeach
</body>
</html>
