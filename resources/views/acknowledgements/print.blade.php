<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Podziękowanie</title>
    <style>
        @include('acknowledgements._print-styles')

        body {
            padding: 60px;
        }
        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body>
    {!! $content !!}
</body>
</html>
