@csrf

<div class="grid gap-6">

    <div>

        <label
            for="name"
            class="label"
        >
            Name
        </label>

        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="input"
            @error('name') aria-invalid="true" @enderror
        >

        @error('name')
            <p class="text-sm text-red-500 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div>

        <label
            for="description"
            class="label"
        >
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
            class="textarea"
        >{{ old('description', $product->description ?? '') }}</textarea>

    </div>

    <div class="grid md:grid-cols-2 gap-6">

        <div>

            <label
                for="price"
                class="label"
            >
                Price
            </label>

            <input
                id="price"
                type="number"
                step="0.01"
                name="price"
                value="{{ old('price', $product->price ?? '') }}"
                class="input"
            >

        </div>

        <div>

            <label
                for="stock_quantity"
                class="label"
            >
                Stock Quantity
            </label>

            <input
                id="stock_quantity"
                type="number"
                min="0"
                name="stock_quantity"
                value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}"
                class="input"
            >

        </div>

    </div>

</div>