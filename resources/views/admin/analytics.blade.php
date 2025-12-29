<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Analisis Penjualan (30 hari terakhir)</h1>
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr><th class="p-2 text-left">Tanggal</th><th class="p-2 text-left">Total</th></tr>
                </thead>
                <tbody>
                    @foreach($salesByDay as $row)
                        <tr class="border-b"><td class="p-2">{{ $row->day }}</td><td class="p-2">Rp{{ number_format($row->total,0,',','.') }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
