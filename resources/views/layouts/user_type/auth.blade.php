{{-- @extends('layouts.app')

@section('auth')
    @if(\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')
    @elseif (\Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')
    @else
        @if (\Request::is('rtl'))
            @include('layouts.navbars.auth.sidebar-rtl')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @include('layouts.navbars.auth.nav-rtl')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @elseif (\Request::is('virtual-reality'))
            @include('layouts.navbars.auth.nav')
            <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('../assets/img/vr-bg.jpg') ; background-size: cover;">
                @include('layouts.navbars.auth.sidebar')
                <main class="main-content mt-1 border-radius-lg">
                    @yield('content')
                </main>
            </div>
            @include('layouts.footers.auth.footer')
        @elseif (\Request::is('profile'))
            @if(Auth::user()->role !== 'pekerja')
                @include('layouts.navbars.auth.sidebar')
                @include('layouts.navbars.auth.nav')
            @endif
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Auth::user()->role === 'pekerja' ? 'w-100' : '' }}">
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @elseif (\Request::is('dashboard') || \Request::is('admin/detail/*'))
            @if(Auth::user()->role !== 'pekerja')
                @include('layouts.navbars.auth.sidebar')
                @include('layouts.navbars.auth.nav')
            @endif
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Auth::user()->role === 'pekerja' ? 'w-100' : '' }}">
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @else
            @if(Auth::user()->role !== 'pekerja')
                @include('layouts.navbars.auth.sidebar')
                @include('layouts.navbars.auth.nav')
            @endif
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Auth::user()->role === 'pekerja' ? 'w-100' : '' }}">
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @endif

        @include('components.fixed-plugin')
    @endif
@endsection --}}

@extends('layouts.app')

@section('auth')


    @if(\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')

    @elseif (\Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
            @yield('content')
        @include('layouts.footers.guest.footer')

    @else
        @if (\Request::is('rtl'))
            @include('layouts.navbars.auth.sidebar-rtl')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @include('layouts.navbars.auth.nav-rtl')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>

        @elseif (\Request::is('profile'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('job/*'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('admin/detail/*'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('admin/job/*/documents'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('admin/job/*/history'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('admin/job-add'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>

        @elseif (\Request::is('admin/tambah-pekerja/*/edit'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('clients/create'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('clients/*/edit'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>
        @elseif (\Request::is('admin/tambah-pekerja'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>

        @elseif (\Request::is('admin/job/*/edit'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>


        @elseif (\Request::is('dashboard'))

            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

                @yield('content')
            </div>

        @elseif (\Request::is('virtual-reality'))
            @include('layouts.navbars.auth.nav')
            <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('../assets/img/vr-bg.jpg') ; background-size: cover;">
                @include('layouts.navbars.auth.sidebar')
                <main class="main-content mt-1 border-radius-lg">
                    @yield('content')
                </main>
            </div>
            @include('layouts.footers.auth.footer')

        @else
            @include('layouts.navbars.auth.sidebar')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
                @include('layouts.navbars.auth.nav')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @endif

        {{-- @include('components.fixed-plugin') --}}
    @endif



@endsection