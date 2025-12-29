<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Promo</h1>
            <a href="{{ route('admin.promos.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Promo</a>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Code</th>
                        <th class="p-3 text-left">Tipe</th>
                        <th class="p-3 text-left">Value</th>
                        <th class="p-3 text-left">Active</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                        <tr class="border-b">
                            <td class="p-3">#{{ $promo->id }}</td>
                            <td class="p-3">{{ $promo->code }}</td>
                            <td class="p-3">{{ $promo->type }}</td>
                            <td class="p-3">{{ $promo->value }}</td>
                            <td class="p-3">{{ $promo->active ? 'Ya' : 'Tidak' }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.promos.edit', $promo->id) }}" class="text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus promo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $promos->links() }}</div>
    </div>
</x-app-layout>
