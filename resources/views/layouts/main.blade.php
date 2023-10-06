<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/dark.js'])
    <title>Kas-buku | @yield('tittle')</title>
    <script>
    
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }


        
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    @include('components.navbar')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('components.sidebar')
        <div id="main-content" class="px-4 pt-6 relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            @yield('content')
            @include('components.footer')
        </div>
    </div>
</body>
</html>