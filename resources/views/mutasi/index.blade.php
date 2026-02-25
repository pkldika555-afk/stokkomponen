@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950 text-gray-100 font-sans">
    <div class="max-w-6xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-violet-400 font-semibold mb-1">Master Data</p>
                <h2 class="text-3xl font-bold text-white">Departemen</h2>
                <p class="text-gray-500 text-sm mt-1">Kelola data departemen perusahaan</p>
            </div>
            <a href="{{ route('departemen.create') }}"
               class="flex items-center gap-2 bg-violet-600 hover:bg-violet-500 text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition-colors duration-200 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Departemen
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl px-5 py-3.5 mb-6 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Total Departemen</p>
                <p class="text-2xl font-bold text-white">{{ $departemen->total() ?? count($departemen) }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Aktif</p>
                <p class="text-2xl font-bold text-emerald-400">{{ $departemen->where('status', 'aktif')->count() ?? '-' }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Non-Aktif</p>
                <p class="text-2xl font-bold text-rose-400">{{ $departemen->where('status', '!=', 'aktif')->count() ?? '-' }}</p>
            </div>
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-5">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari departemen..."
                    class="w-full bg-gray-900 border border-gray-800 text-gray-100 rounded-xl pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition placeholder-gray-600">
            </div>
        </form>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-200">Daftar Departemen</p>
                <span class="text-xs bg-gray-800 text-gray-400 px-3 py-1 rounded-full">{{ $departemen->total() ?? count($departemen) }} item</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-800/60 text-xs uppercase tracking-wider text-gray-400">
                            <th class="text-left px-6 py-3 font-semibold w-10">#</th>
                            <th class="text-left px-6 py-3 font-semibold">Nama Departemen</th>
                            <th class="text-left px-6 py-3 font-semibold">Kode</th>
                            <th class="text-left px-6 py-3 font-semibold">Kepala Dept.</th>
                            <th class="text-left px-6 py-3 font-semibold">Status</th>
                            <th class="text-center px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($departemen as $d)
                        <tr class="hover:bg-gray-800/40 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-600 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $colors = ['bg-violet-500/20 text-violet-300 border-violet-500/30', 'bg-blue-500/20 text-blue-300 border-blue-500/30', 'bg-amber-500/20 text-amber-300 border-amber-500/30', 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'];
                                        $color = $colors[$loop->index % count($colors)];
                                    @endphp
                                    <div class="w-8 h-8 rounded-lg {{ $color }} border flex items-center justify-center shrink-0 font-bold text-xs">
                                        {{ strtoupper(substr($d->nama_departemen, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-gray-100">{{ $d->nama_departemen }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-800 text-violet-300 px-2 py-1 rounded-md font-mono">{{ $d->kode ?? '-' }}</code>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $d->kepala ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if(($d->status ?? 'aktif') == 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-700/50 text-gray-400 border border-gray-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('departemen.edit', $d->id) }}"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 hover:bg-amber-500/20 transition-colors"
                                       title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('departemen.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus departemen ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500/20 transition-colors"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Belum ada data departemen</p>
                                    <a href="{{ route('departemen.create') }}" class="text-violet-400 hover:text-violet-300 text-xs underline underline-offset-2">Tambah sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($departemen, 'links'))
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $departemen->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection