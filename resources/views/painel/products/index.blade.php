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
            class="flex gap-2 mb-6"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Pesquisar produto..."
                class="input"
            >

            <button
                type="submit"
                class="btn btn-outline"
            >
                Pesquisar
            </button>

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

                                @if($product->stock_quantity > 10)

                                    <span class="badge">
                                        {{ $product->stock_quantity }}
                                    </span>

                                @elseif($product->stock_quantity > 0)

                                    <span class="badge badge-secondary">
                                        {{ $product->stock_quantity }}
                                    </span>

                                @else

                                    <span class="badge badge-destructive">
                                        Out of stock
                                    </span>

                                @endif

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
                                        View
                                    </a>

                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="dropdown-item"
                                    >
                                        Edit
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
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr class="table-row">

                            <td
                                colspan="4"
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