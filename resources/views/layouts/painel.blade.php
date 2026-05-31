@extends('layouts.app')

@section('content')

<div class="sidebar sidebar-inset">

    <div class="sidebar-backdrop"></div>

    @include('components.painel.sidebar')

    <main class="sidebar-page flex flex-col">

        <header class="flex items-center gap-2 border-b px-4 h-14">

            <button
                class="btn btn-ghost btn-icon-sm -ml-2"
                data-sp-toggle="sidebar"
                data-sp-target="#sidebar-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                    <path d="M9 3v18"></path>
                </svg>
            </button>

            <div
                class="separator separator-vertical self-center h-4 -ml-1 mr-2">
            </div>

            <nav class="breadcrumb text-sm">

                <a href="{{ route('dashboard.index') }}"
                   class="breadcrumb-link">
                    First Decision Test
                </a>

                <span class="breadcrumb-separator">
                    >
                </span>

                @yield('breadcrumb')

            </nav>

        </header>

        <div class="flex flex-1 flex-col gap-4 p-4">

            @yield('page-content')

        </div>

    </main>

</div>

@endsection