<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased m-0 p-0">
    @inertia
</body>

<script>
    function getPreferredColorScheme() {
        if (window.matchMedia) {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                return 'dark';
            }
        }
        return 'light';
    }
    function updateColorScheme() {
        let html = document.querySelector("html")
        if (cs == "dark") {
            if (html.classList.contains("light")) {
                html.classList.remove("light")
            }
            html.classList.add("dark")
        } else {
            if (html.classList.contains("dark")) {
                html.classList.remove("dark")
            }
            html.classList.add("light")
        }
    }
    let cs = localStorage.getItem("colorScheme")
    if (cs == null) {
        localStorage.setItem("colorScheme", getPreferredColorScheme())
    }
    updateColorScheme()
</script>

</html>