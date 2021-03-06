<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileServer</title>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        body {
            background-color: #e8e8e8;
        }
    </style>
</head>
<body>
    
    <div class="container">
    
        <h4>{{ env('APP_NAME') }}</h4>

        <div class="md-12">
        
           @yield('content')
        
        </div>

    </div>

</body>
</html>