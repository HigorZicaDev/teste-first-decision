@csrf

<div class="grid gap-6">

    <div class="field">

        <label
            for="name"
            class="label"
        >
            Nome
        </label>

        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="input"
            required
            @error('name') aria-invalid="true" @enderror
        >

        @error('name')
            <p class="text-sm text-red-500 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div class="field">

        <label
            for="description"
            class="label"
        >
            Descriçao
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
            class="textarea"
        >{{ old('description', $product->description ?? '') }}</textarea>

    </div>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="field">

            <label
                for="price"
                class="label"
            >
                Preço
            </label>

            <input
                id="price"
                type="number"
                step="0.01"
                min="0.01"
                name="price"
                value="{{ old('price', $product->price ?? '') }}"
                class="input"
                required
                @error('price') aria-invalid="true" @enderror
            >

            @error('price')
                <p class="text-sm text-red-500 mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div class="field">

            <label
                for="quantity_in_stock"
                class="label"
            >
                Quantidade em estoque
            </label>

            <input
                id="quantity_in_stock"
                type="number"
                min="0"
                name="quantity_in_stock"
                value="{{ old('quantity_in_stock', $product->quantity_in_stock ?? '') }}"
                class="input"
                required
                @error('quantity_in_stock') aria-invalid="true" @enderror
            >

            @error('quantity_in_stock')
                <p class="text-sm text-red-500 mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

    </div>

</div>