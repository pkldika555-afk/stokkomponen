@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950 text-gray-100 font-sans">
    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-0.5">Gudang</p>
                <h2 class="text-2xl font-bold text-white">Mutasi Barang</h2>
                <p class="text-gray-500 text-xs mt-0.5">History keluar masuk komponen</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('mutasi.rekap') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-700 text-gray-400 hover:text-gray-200 hover:border-gray-600 text-sm font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Rekap Stok
                </a>
                <a href="{{ route('mutasi.create') }}"
                    class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl px-4 py-2 text-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Mutasi
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl px-4 py-3 mb-5 flex items-center gap-2 text-emerald-400 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('mutasi.index') }}"
            class="bg-gray-900 border border-gray-800 rounded-xl px-5 py-4 mb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Komponen</label>
                    <select name="id_komponen"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua Komponen</option>
                        @foreach($komponen as $k)
                            <option value="{{ $k->id }}" {{ request('id_komponen') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_komponen }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Jenis</label>
                    <select name="jenis"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua Jenis</option>
                        <option value="pembelian"      {{ request('jenis') == 'pembelian'      ? 'selected' : '' }}>Pembelian</option>
                        <option value="internal"       {{ request('jenis') == 'internal'       ? 'selected' : '' }}>Pemakaian Internal</option>
                        <option value="retur"          {{ request('jenis') == 'retur'          ? 'selected' : '' }}>Retur</option>
                        <option value="repair_kembali" {{ request('jenis') == 'repair_kembali' ? 'selected' : '' }}>Repair Kembali</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                    <div class="flex gap-2">
                        <input type="date" name="sampai" value="{{ request('sampai') }}"
                            class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg px-3 py-2 text-xs font-medium transition-colors shrink-0">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
            @if(request()->hasAny(['jenis','id_komponen','dari','sampai']))
                <div class="mt-2 text-right">
                    <a href="{{ route('mutasi.index') }}" class="text-xs text-gray-500 hover:text-gray-300 underline">Reset filter</a>
                </div>
            @endif
        </form>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Komponen</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dari → Ke</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($mutasi as $m)
                        @php
                            $isMasuk = in_array($m->jenis, \App\Models\MasterKomponen::JENIS_MASUK);
                            $jenisColor = match($m->jenis) {
                                'pembelian'      => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                'internal'       => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                                'retur'          => 'text-sky-400 bg-sky-500/10 border-sky-500/20',
                                'repair_kembali' => 'text-violet-400 bg-violet-500/10 border-violet-500/20',
                                default          => 'text-gray-400 bg-gray-800 border-gray-700',
                            };
                        @endphp
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-gray-200 text-sm font-medium">{{ $m->tanggal }}</p>
                                <p class="text-gray-600 text-xs">{{ $m->created_at?->format('H:i') }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="text-gray-200 text-sm">{{ $m->komponen->nama_komponen ?? '-' }}</p>
                                <p class="text-gray-600 text-xs font-mono">{{ $m->komponen->kode_komponen ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-medium {{ $jenisColor }}">
                                    {{ $m->label_jenis }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-400">
                                <span>{{ $m->departemenAsal->nama_departemen ?? '-' }}</span>
                                <span class="mx-1 text-gray-700">→</span>
                                <span>{{ $m->departemenTujuan->nama_departemen ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="font-mono font-semibold text-sm {{ $isMasuk ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $isMasuk ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                </span>
                                <p class="text-xs text-gray-600">{{ $m->komponen->satuan ?? 'unit' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('mutasi.show', $m->id_mutasi) }}"
                                    class="inline-flex items-center gap-1 text-xs text-indigo-400 hover:text-indigo-300 transition-colors">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-sm">Belum ada data mutasi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($mutasi->hasPages())
                <div class="px-5 py-3 border-t border-gray-800 flex items-center justify-between">
                    <p class="text-xs text-gray-600">
                        Menampilkan {{ $mutasi->firstItem() }}–{{ $mutasi->lastItem() }} dari {{ $mutasi->total() }} data
                    </p>
                    {{ $mutasi->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection