<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
      
         <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!--styles -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

    </head>
    <body>

        <div id="app" class="d-flex h-screen flex-column justify-content-between">

            <header>
                <h1 class="text-center">Tareas {{ date('Y') }}</h1>
            </header>

            <main class="py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-10 col-lg-6 mx-auto">
                            <example-component></example-component>
                           
                        </div>
                    </div>
                </div>
            </main>

            <!--footer class="bg-white text-center text-black-50 py-3 shadow">
                {{ config('app.name') }} | Copyright @ {{ date('Y') }}
            </footer-->
                 
        </div>

    </body>
</html>
