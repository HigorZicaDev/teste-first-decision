@extends('layouts.painel')

@section('breadcrumb')
    <span class="breadcrumb-page">
        Dashboard
    </span>
@endsection

@section('page-content')

<div class="grid auto-rows-min gap-4 md:grid-cols-3">
    <div class="bg-muted/50 aspect-video rounded-xl"></div>
    <div class="bg-muted/50 aspect-video rounded-xl"></div>
    <div class="bg-muted/50 aspect-video rounded-xl"></div>
</div>

<div class="bg-muted/50 min-h-40 flex-1 rounded-xl"></div>

@endsection