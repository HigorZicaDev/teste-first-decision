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
                        {{ $product->name }}
                    </h1>

                    <p class="text-muted-foreground">
                        Product details
                    </p>

                </div>

                <a
                    href="{{ route('products.edit', $product) }}"
                    class="btn btn-outline"
                >
                    Edit
                </a>

            </div>

            <div class="grid gap-6">

                <div>
                    <h3 class="font-medium mb-2">
                        Description
                    </h3>

                    <p>
                        {{ $product->description ?: 'No description provided.' }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <h3 class="font-medium mb-2">
                            Price
                        </h3>

                        <p>
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </p>

                    </div>

                    <div>

                        <h3 class="font-medium mb-2">
                            Stock Quantity
                        </h3>

                        <p>
                            {{ $product->stock_quantity }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection