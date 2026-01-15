<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900">➕ Tambah Kategori Baru</h1>
                <p class="text-slate-600 mt-2">Buat kategori produk baru untuk mengorganisir produk Anda</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h2 class="text-xl font-bold text-white">Informasi Kategori</h2>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <!-- Nama Kategori -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-900 mb-3">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               placeholder="Contoh: Alat Tulis, Kertas, Buku, dll"
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border-2 @error('name') border-red-500 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586l-6.687-6.687a1 1 0 00-1.414 1.414l8 8a1 1 0 001.414 0l10-10z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-900 mb-3">
                            Deskripsi <span class="text-slate-500">(Opsional)</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="5"
                                  placeholder="Deskripsikan kategori ini... (mis: Perlengkapan tulis untuk sekolah dan kantor)"
                                  class="w-full px-4 py-3 border-2 @error('description') border-red-500 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586l-6.687-6.687a1 1 0 00-1.414 1.414l8 8a1 1 0 001.414 0l10-10z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-slate-200">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Kategori
                        </button>
                        <a href="{{ route('categories.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-900 font-bold py-3 px-6 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>