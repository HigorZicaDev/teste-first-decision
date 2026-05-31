@extends('layouts.painel')

@section('breadcrumb')
    <span class="breadcrumb-page">
        Dashboard
    </span>
@endsection

@section('page-content')

<div class="grid auto-rows-min gap-4 md:grid-cols-4">

    <div class="card">
        <div class="card-content">
            <p class="text-sm text-muted-foreground">Total de produtos</p>
            <p class="text-3xl font-semibold mt-2">
                {{ $metrics['total_products'] }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <p class="text-sm text-muted-foreground">Unidades em estoque</p>
            <p class="text-3xl font-semibold mt-2">
                {{ number_format($metrics['total_stock'], 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <p class="text-sm text-muted-foreground">Valor do estoque</p>
            <p class="text-3xl font-semibold mt-2">
                R$ {{ number_format($metrics['inventory_value'], 2, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <p class="text-sm text-muted-foreground">Estoque baixo</p>
            <p class="text-3xl font-semibold mt-2">
                {{ $metrics['low_stock'] }}
            </p>
            <p class="text-sm text-muted-foreground mt-1">
                {{ $metrics['out_of_stock'] }} esgotado(s)
            </p>
        </div>
    </div>

</div>

<div class="card mt-4">
    <div class="card-content">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold">Produtos com estoque baixo</h2>
                <p class="text-muted-foreground">
                    Itens com até 9 unidades disponíveis
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline">
                Ver produtos
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header">
                    <tr class="table-row">
                        <th class="table-head">Nome</th>
                        <th class="table-head">Preço</th>
                        <th class="table-head">Quantidade em estoque</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse($lowStockProducts as $product)
                        <tr class="table-row">
                            <td class="table-cell">{{ $product->name }}</td>
                            <td class="table-cell">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </td>
                            <td class="table-cell">
                                <span class="badge badge-destructive">
                                    {{ $product->quantity_in_stock }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr class="table-row">
                            <td colspan="3" class="table-cell text-center">
                                Nenhum produto com estoque baixo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
