@extends('layouts.painel')

@section('breadcrumb')

<a
    href="{{ route('products.index') }}"
    class="breadcrumb-link"
>
    Produtos
</a>

<span class="breadcrumb-separator">
    >
</span>

<span class="breadcrumb-page">
    Cadastrar
</span>

@endsection

@section('page-content')

<div class="max-w-4xl">

    <div class="card">

        <div class="card-content">

            <h1 class="text-xl font-semibold mb-6">
                Create Product
            </h1>

            <form
                method="POST"
                action="{{ route('products.store') }}"
            >

                @include('painel.products.partials.form')

                <div class="flex justify-end mt-6">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Product
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection