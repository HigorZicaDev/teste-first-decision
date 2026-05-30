@extends('layouts.app')

@section('content')
<div class="sidebar sidebar-inset">
  <div class="sidebar-backdrop"></div>
    {{-- ================= SIDEBAR ================= --}}
    @include('components.painel.sidebar')

    <main class="sidebar-page flex flex-col">
      <header class="flex items-center gap-2 border-b px-4 h-14">
        <button
          class="btn btn-ghost btn-icon-sm -ml-2"
          data-sp-toggle="sidebar"
          data-sp-target="#sidebar-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path></svg>
        </button>
        <div
          class="separator separator-vertical self-center h-4 -ml-1 mr-2"
        ></div>
        <nav class="breadcrumb text-sm">
          <a href="#" class="breadcrumb-link">First Decision Teste</a>
          <span class="breadcrumb-separator" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
          </span>
          <span class="breadcrumb-page">Dashboard</span>
        </nav>
      </header>
      <div class="flex flex-1 flex-col gap-4 p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <div class="bg-muted/50 aspect-video rounded-xl"></div>
          <div class="bg-muted/50 aspect-video rounded-xl"></div>
          <div class="bg-muted/50 aspect-video rounded-xl"></div>
        </div>
        <div class="bg-muted/50 min-h-40 flex-1 rounded-xl"></div>
      </div>
    </main>
</div>

@endsection
