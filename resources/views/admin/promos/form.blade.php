<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">@if(isset($promo)) Edit Promo @else Buat Promo @endif</h1>
        <form action="@if(isset($promo)) {{ route('admin.promos.update', $promo->id) }} @else {{ route('admin.promos.store') }} @endif" method="POST">
            @csrf
            @if(isset($promo)) @method('PATCH') @endif
            <div class="mb-3">
                <label class="block text-sm">Code</label>
                <input type="text" name="code" value="{{ $promo->code ?? old('code') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Tipe</label>
                <select name="type" class="w-full border p-2 rounded">
                    <option value="percent" @if(($promo->type ?? '')=='percent') selected @endif>Percent</option>
                    <option value="fixed" @if(($promo->type ?? '')=='fixed') selected @endif>Fixed</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Value</label>
                <input type="number" step="0.01" name="value" value="{{ $promo->value ?? old('value') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="active" @if(($promo->active ?? true)) checked @endif class="mr-2"> Active
                </label>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
