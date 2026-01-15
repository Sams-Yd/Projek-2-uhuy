<x-app-layout>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8 flex items-center justify-between">
        <div>
          <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
            👥 Kelola User
          </h1>
          <p class="text-slate-600 mt-2">Atur role dan status user di sistem</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
          Kembali ke Dashboard
        </a>
      </div>

      <!-- Success Alert -->
      @if(session('success'))
        <div class="glass-effect rounded-lg p-4 mb-6 bg-green-50 border-l-4 border-green-500">
          <p class="text-green-700 font-semibold">✓ {{ session('success') }}</p>
        </div>
      @endif

      @if(session('error'))
        <div class="glass-effect rounded-lg p-4 mb-6 bg-red-50 border-l-4 border-red-500">
          <p class="text-red-700 font-semibold">✕ {{ session('error') }}</p>
        </div>
      @endif

      <!-- Users Table -->
      <div class="glass-effect rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
              <tr>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">ID</th>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">Nama</th>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">Email</th>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">Role</th>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">Status</th>
                <th class="px-6 py-4 text-left font-semibold text-slate-900">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                  <td class="px-6 py-4 text-slate-900 font-medium">#{{ $user->id }}</td>
                  <td class="px-6 py-4 text-slate-900">{{ $user->name }}</td>
                  <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                  <td class="px-6 py-4">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                      @if($user->isAdmin())
                        bg-purple-100 text-purple-800
                      @else
                        bg-blue-100 text-blue-800
                      @endif
                    ">
                      {{ ucfirst($user->role) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    @if($user->isActive())
                      <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        ✓ Aktif
                      </span>
                    @else
                      <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                        ✕ Nonaktif
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-block px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition">
                      ✎ Edit
                    </a>
                    @if($user->id !== auth()->id())
                      <form action="{{ route('admin.users.toggle-status', $user) }}" method="post" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition">
                          {{ $user->isActive() ? '⊘ Nonaktifkan' : '✓ Aktifkan' }}
                        </button>
                      </form>
                      <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition">
                          🗑️ Hapus
                        </button>
                      </form>
                    @else
                      <span class="inline-block px-3 py-2 text-sm text-slate-500">(Akun Anda)</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                    Tidak ada user
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
          <div class="px-6 py-4 border-t border-slate-200 flex justify-center">
            {{ $users->links() }}
          </div>
        @endif
      </div>

      <!-- Info Box -->
      <div class="mt-8 glass-effect rounded-lg p-4 bg-blue-50">
        <p class="text-blue-800 flex items-start gap-2">
          <span>ℹ️</span>
          <span><strong>Catatan:</strong> User dengan role "admin" memiliki akses ke panel admin. Anda tidak dapat menghapus atau menonaktifkan akun sendiri.</span>
        </p>
      </div>
    </div>
  </div>
</x-app-layout>