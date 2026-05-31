@extends('layouts.painel')

@section('breadcrumb')

<a href="{{ route('products.index') }}"
   class="breadcrumb-link">
    Produtos
</a>

<span class="breadcrumb-separator">
    >
</span>

<span class="breadcrumb-page">
    Detalhes
</span>

@endsection

@section('page-content')

<div class="max-w-4xl">

    <div class="card">

        <div class="card-content">

            <div class="flex justify-between items-start mb-8">

                <div>

                    <h1 class="text-2xl font-semibold">
                       Nome: {{ $product->name }}
                    </h1>

                </div>

                <a
                    href="{{ route('products.edit', $product) }}"
                    class="btn btn-outline"
                >
                    Editar
                </a>

            </div>

            <div class="grid gap-6">

                <div>
                    <h3 class="font-medium mb-2">
                        Descriçao: {{ $product->description ?: 'No description provided.' }}
                    </h3>

                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <h3 class="font-medium mb-2">
                            Preço: R$ {{ number_format($product->price, 2, ',', '.') }}
                        </h3>

                        <p>
                            
                        </p>

                    </div>

                    <div>

                        <h3 class="font-medium mb-2">
                            Quantidade em estoque: {{ $product->quantity_in_stock }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection