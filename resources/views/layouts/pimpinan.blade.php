<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Pimpinan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar - Fixed -->
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0 fixed h-screen overflow-y-auto">
            <div class="p-6">
                <h1 class="text-2xl font-bold">E-Disposisi</h1>
                <p class="text-sm text-gray-400">BMKG - Pimpinan</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('pimpinan.dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('pimpinan.dashboard') ? 'bg-slate-700 border-l-4 border-white' : 'hover:bg-slate-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('pimpinan.surat-masuk.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('pimpinan.surat-masuk.*') ? 'bg-slate-700 border-l-4 border-white' : 'hover:bg-slate-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Surat Masuk
                </a>
                
                <a href="{{ route('pimpinan.disposisi.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('pimpinan.disposisi.*') ? 'bg-slate-700 border-l-4 border-white' : 'hover:bg-slate-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Disposisi Surat
                </a>
            </nav>
        </aside>

        <!-- Main Content - With left margin to account for fixed sidebar -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Navbar -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <div class="relative">
                            <button onclick="document.getElementById('dropdown').classList.toggle('hidden')" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <svg class="w-8 h-8 rounded-full bg-slate-800 text-white p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                            
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>