@extends('layouts.site')
@section('content')
<div class="card w-full max-w-sm">
  <div class="card-content grid gap-6">
    <div>
      <h3 class="text-lg font-semibold tracking-tight">Criar conta</h3>
      <p class="text-sm/6 text-muted-foreground mt-2">
        Preencha os dados abaixo para criar um conta de acesso a plataforma
      </p>
    </div>
    <div class="relative" role="separator">
      <div class="absolute inset-0 flex items-center">
        <span class="w-full border-t"></span>
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-card px-2 text-muted-foreground">Continue</span>
      </div>
    </div>
    <form class="field-group" action="{{ route('register.store') }}" method="post">
      @csrf
      <div class="field">
        <label class="label" for="name">Nome</label>
        <input
          class="input"
          id="name"
          type="text"
          placeholder="Usuario Teste"
          name="name"
          value="{{ old('name') }}"
        />
        @error('name')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="field">
        <label class="label" for="email">E-mail</label>
        <input
          class="input"
          id="email"
          type="email"
          placeholder="usertest@example.com"
          name="email"
          value="{{ old('email') }}"
        />
        @error('email')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="field">
        <label class="label" for="password">Senha</label>
        <input class="input" id="password" type="password" name="password" />
        @error('password')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="field">
        <label class="label" for="password_confirmation">Confirmar senha</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" />
      </div>
      <button class="btn btn-primary" type="submit">Criar conta</button>
    </form>
    <p class="text-sm text-center text-muted-foreground">
      Ja possui uma conta?
      <a
        href="{{route('login')}}"
        class="text-foreground font-medium underline underline-offset-4"
      >
        Login
      </a>
    </p>
  </div>
</div>

@endsection
