@extends('layouts.painel')

@section('breadcrumb')
    <span class="breadcrumb-page">
        Produtos
    </span>
@endsection

@section('page-content')

<div class="card">

    <div class="card-content">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-semibold">
                    Produtos
                </h1>

                <p class="text-muted-foreground">
                    Gerencie seus produtos cadastrados no estoque
                </p>
            </div>

            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary"
            >
                Novo Produto
            </a>

        </div>

        <form
            method="GET"
            class="grid gap-4 mb-6 md:grid-cols-6 md:items-end"
        >

            <div class="md:col-span-2 field">
                <label for="search" class="label">Buscar</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nome do produto..."
                    class="input"
                >
            </div>

            <div class="field">
                <label for="price_min" class="label">Preço mín.</label>
                <input
                    id="price_min"
                    type="number"
                    step="0.01"
                    name="price_min"
                    value="{{ request('price_min') }}"
                    class="input"
                >
            </div>

            <div class="field">
                <label for="price_max" class="label">Preço máx.</label>
                <input
                    id="price_max"
                    type="number"
                    step="0.01"
                    name="price_max"
                    value="{{ request('price_max') }}"
                    class="input"
                >
            </div>

            <div class="field">
                <label for="stock_min" class="label">Estoque mín.</label>
                <input
                    id="stock_min"
                    type="number"
                    name="stock_min"
                    value="{{ request('stock_min') }}"
                    class="input"
                >
            </div>

            <div class="field">
                <label for="stock_max" class="label">Estoque máx.</label>
                <input
                    id="stock_max"
                    type="number"
                    name="stock_max"
                    value="{{ request('stock_max') }}"
                    class="input"
                >
            </div>

            <div class="flex gap-2 md:col-span-6">
                <button type="submit" class="btn btn-primary">
                    Filtrar
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-outline">
                    Limpar
                </a>
            </div>

        </form>

        <div class="overflow-x-auto">

            <table class="table">

                <thead class="table-header">

                    <tr class="table-row">

                        <th class="table-head">
                            Nome
                        </th>

                        <th class="table-head">
                            Preço
                        </th>

                        <th class="table-head">
                            Quantidade em estoque
                        </th>

                        <th class="table-head">
                            Status
                        </th>

                        <th class="table-head text-right">
                            Açoes
                        </th>

                    </tr>

                </thead>

                <tbody class="table-body">

                    @forelse($products as $product)

                        <tr class="table-row">

                            <td class="table-cell">
                                {{ $product->name }}
                            </td>

                            <td class="table-cell">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </td>

                            <td class="table-cell">

                                @if($product->quantity_in_stock > 10)

                                    <span class="badge">
                                        {{ $product->quantity_in_stock }}
                                    </span>

                                @elseif($product->quantity_in_stock > 0)

                                    <span class="badge badge-secondary">
                                        {{ $product->quantity_in_stock }}
                                    </span>

                                @else

                                    <span class="badge badge-destructive">
                                        Out of stock
                                    </span>

                                @endif

                            </td>

                            <td class="table-cell">

                                @php
                                    $statusMap = [
                                        'green' => ['badge bg-green-500 text-white border-transparent', 'Em estoque'],
                                        'yellow' => ['badge bg-yellow-500 text-black border-transparent', 'Baixo'],
                                        'red' => ['badge badge-destructive', 'Crítico'],
                                    ];
                                    [$statusClass, $statusLabel] = $statusMap[$product->stock_status];
                                @endphp

                                <span class="{{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>

                            </td>

                            <td class="table-cell text-right">

                                <button
                                    class="btn btn-ghost btn-icon-sm"
                                    data-sp-toggle="dropdown"
                                    data-sp-target="#menu-{{ $product->id }}"
                                    aria-expanded="false"
                                >
                                    ⋮
                                </button>

                                <div
                                    id="menu-{{ $product->id }}"
                                    class="dropdown"
                                >

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="dropdown-item"
                                    >
                                        Detalhes
                                    </a>

                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="dropdown-item"
                                    >
                                        Editar
                                    </a>

                                    <div class="dropdown-separator"></div>

                                    <form
                                        method="POST"
                                        action="{{ route('products.destroy', $product) }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="dropdown-item text-red-500"
                                        >
                                            Excluir
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr class="table-row">

                            <td
                                colspan="5"
                                class="table-cell text-center"
                            >
                                Nao existem produtos cadastrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>

</div>

@endsection