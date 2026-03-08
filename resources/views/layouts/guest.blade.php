<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CXR') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="font-sans text-gray-900 antialiased bg-gray-50 min-h-screen d-flex flex-column">
            
            <main class="flex-grow-1">
                {{ $slot }}
            </main>

            <footer class="py-4 bg-white border-top mt-auto">
                <div class="container" style="max-width: 1100px;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <x-application-mark class="h-10 w-auto" />
                            </div>
                            <div class="border-start ps-3 border-gray-200">
                                <div class="fw-bold text-blue-600 mb-0" style="font-size: 0.85rem; letter-spacing: 0.5px;">BASIC RESEARCH</div>
                                <div class="text-gray-900 fw-bold" style="font-size: 1.1rem; line-height: 1;">
                                    CXR <span class="text-primary text-blue-600">ChangeDetection</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center text-md-end">
                            <div class="text-gray-500 mb-1" style="font-size: 0.8rem;">
                                © 2026 CXR ChangeDetection | Developed by <strong class="text-gray-700">Basic Research</strong>. All rights reserved.
                            </div>
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2">
                                <span class="text-gray-400" style="font-size: 0.75rem;">College of Computing, Khon Kaen University</span>
                            </div>
                        </div>

                    </div>
                </div>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @livewireScripts
    </body>
</html>