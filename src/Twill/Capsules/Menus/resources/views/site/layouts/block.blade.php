<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/assets/hl.png">
    @include('layout.styles')
</head>
<body class="font-inter antialiased bg-gray-900 text-white tracking-tight">

<div id="app">
    <div class="flex flex-col min-h-screen overflow-hidden">
        <main class="grow">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>