<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only([
            'search',
            'price_min',
            'price_max',
            'stock_min',
            'stock_max',
        ]);

        $products = Product::query()
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'painel.products.index',
            compact('products', 'filters')
        );
    }

    public function create(): View
    {
        return view('painel.products.create');
    }

    public function store(
        StoreProductRequest $request
    ): RedirectResponse {
        $product = $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produto criado com sucesso.');
    }

    public function show(
        Product $product
    ): View {
        return view('painel.products.show', compact('product'));
    }

    public function edit(
        Product $product
    ): View {
        return view('painel.products.edit', compact('product'));
    }

    public function update(
        UpdateProductRequest $request,
        Product $product
    ): RedirectResponse {
        $this->service->update(
            $product,
            $request->validated()
        );

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produto editado com sucesso.');
    }

    public function destroy(
        Product $product
    ): RedirectResponse {
        $this->service->delete($product);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto excluido com sucesso.');
    }
}
