<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark h-100">
                <div class="container">
                    <!-- logo -->
                    <a class="navbar-brand" href="{{ Route('home') }}">Boolfolio</a>

                    <!-- dropdown menu (when page resized) -->
                    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsibleNavId, #sidebarMenu" aria-controls="collapsibleNavId, sidebarMenu"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- menu links -->
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ Route('home') }}">Home</a>
                            </li>
                        </ul>

                        <!-- sign out -->
                        <div class="nav-item text-nowrap">
                            <a class="nav-link px-3 text-light" href="">Sign out</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light px-0 sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}"
                                    aria-current="page" href="{{ Route('admin.dashboard') }}">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    <i class="fa-solid fa-gauge-simple-high"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() === 'admin.projects.index' ? 'active' : '' }}"
                                    href="{{ Route('admin.projects.index') }}">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    <i class="fa-solid fa-folder-open"></i>
                                    Projects
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() === 'admin.types.index' ? 'active' : '' }}"
                                    href="{{ Route('admin.types.index') }}">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    <i class="fa-solid fa-folder"></i>
                                    Types
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() === 'admin.technologies.index' ? 'active' : '' }}"
                                    href="{{ Route('admin.technologies.index') }}">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    <i class="fa-solid fa-microchip"></i>
                                    Technologies
                                </a>
                            </li>
                        </ul>
                    </div>

                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>
