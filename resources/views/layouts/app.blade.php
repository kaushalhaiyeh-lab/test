<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HR Portal')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Header --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-indigo-600">
                HR Portal
            </a>

            <nav class="space-x-6">
                <a href="/" class="hover:text-indigo-600">Home</a>
                <a href="/services" class="hover:text-indigo-600">Services</a>
                <a href="/jobs" class="hover:text-indigo-600">Jobs</a>
                <a href="/admin" class="text-indigo-600 font-semibold">Admin</a>
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white font-bold text-lg">HR Portal</h3>
                <p class="mt-2 text-sm">
                    Smart hiring & HR management platform.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold">Quick Links</h4>
                <ul class="mt-2 space-y-2 text-sm">
                    <li><a href="/services" class="hover:text-white">Services</a></li>
                    <li><a href="/jobs" class="hover:text-white">Jobs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold">Contact</h4>
                <p class="text-sm mt-2">support@hrportal.com</p>
            </div>
        </div>

        <div class="text-center text-sm py-4 bg-gray-800">
            © {{ date('Y') }} HR Portal. All rights reserved.
        </div>
    </footer>

</body>
</html>
