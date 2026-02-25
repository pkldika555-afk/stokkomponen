@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-950 text-gray-100 font-sans">
        <div class="max-w-3xl mx-auto px-6 py-8">

            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('komponen.index') }}"
                    class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-300 text-xs transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Komponen
                </a>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-0.5">Master Data</p>
                        <h2 class="text-2xl font-bold text-white leading-tight">Edit Komponen</h2>
                    </div>
                    {{-- Info chips --}}
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1.5 bg-gray-900 border border-gray-800 rounded-lg px-3 py-1.5 text-xs text-gray-400">
                            <code class="font-mono text-indigo-400">#{{ str_pad($komponen->id, 4, '0', STR_PAD_LEFT) }}</code>
                        </span>
                        <span class="flex items-center gap-1.5 bg-gray-900 border border-gray-800 rounded-lg px-3 py-1.5 text-xs {{ ($komponen->stok ?? 0) > ($komponen->stok_minimal ?? 0) ? 'text-emerald-400 border-emerald-900/40' : 'text-rose-400 border-rose-900/40' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ ($komponen->stok ?? 0) > ($komponen->stok_minimal ?? 0) ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                            Stok: {{ number_format($komponen->stok ?? 0) }} {{ $komponen->satuan ?? 'unit' }}
                        </span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-1">Memperbarui: <span class="text-indigo-400 font-medium">{{ $komponen->nama_komponen }}</span>
                    @if($komponen->updated_at)
                        &mdash; <span class="text-gray-600">Diubah {{ $komponen->updated_at->format('d M Y, H:i') }}</span>
                    @endif
                </p>
            </div>

            {{-- Error alert --}}
            @if($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 rounded-xl px-4 py-3 mb-5 flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-rose-400 font-semibold text-xs mb-1">Terdapat kesalahan input</p>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li class="text-rose-300 text-xs">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('komponen.update', $komponen->id) }}" method="POST"
                class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
                @csrf
                @method('PUT')

                <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-200">Informasi Komponen</p>
                        <p class="text-xs text-gray-500 mt-0.5">Ubah data yang diperlukan lalu simpan</p>
                    </div>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label for="nama_komponen" class="block text-xs font-medium text-gray-400 mb-1.5">
                            Nama Komponen <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="nama_komponen" name="nama_komponen"
                            value="{{ old('nama_komponen', $komponen->nama_komponen) }}"
                            placeholder="Contoh: Resistor 10K Ohm"
                            class="w-full bg-gray-800 border {{ $errors->has('nama_komponen') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-600">
                        @error('nama_komponen')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="kode_komponen" class="block text-xs font-medium text-gray-400 mb-1.5">Kode Komponen</label>
                            <input type="text" id="kode_komponen" name="kode_komponen"
                                value="{{ old('kode_komponen', $komponen->kode_komponen) }}" placeholder="KMP-001"
                                class="w-full bg-gray-800 border {{ $errors->has('kode_komponen') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-600 font-mono">
                            @error('kode_komponen')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="satuan" class="block text-xs font-medium text-gray-400 mb-1.5">Satuan <span class="text-rose-400">*</span></label>
                            <select id="satuan" name="satuan"
                                class="w-full bg-gray-800 border {{ $errors->has('satuan') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih —</option>
                                @foreach(['pcs', 'unit', 'buah', 'set', 'meter', 'roll', 'kg', 'liter', 'box', 'pak'] as $s)
                                    <option value="{{ $s }}" {{ old('satuan', $komponen->satuan) == $s ? 'selected' : '' }}>{{ strtoupper($s) }}</option>
                                @endforeach
                            </select>
                            @error('satuan')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tipe" class="block text-xs font-medium text-gray-400 mb-1.5">Tipe <span class="text-rose-400">*</span></label>
                            <select id="tipe" name="tipe"
                                class="w-full bg-gray-800 border {{ $errors->has('tipe') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih —</option>
                                @foreach(['consumable', 'repairable'] as $s)
                                    <option value="{{ $s }}" {{ old('tipe', $komponen->tipe) == $s ? 'selected' : '' }}>{{ strtoupper($s) }}</option>
                                @endforeach
                            </select>
                            @error('tipe')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="stok_minimal" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Stok Minimum
                                <span class="text-gray-600 font-normal">(alert)</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="stok_minimal" name="stok_minimal"
                                    value="{{ old('stok_minimal', $komponen->stok_minimal) }}" min="0"
                                    class="w-full bg-gray-800 border {{ $errors->has('stok_minimal') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-600">unit</span>
                            </div>
                            @error('stok_minimal')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="rak" class="block text-xs font-medium text-gray-400 mb-1.5">Rak</label>
                            <div class="relative">
                                <input type="number" id="rak" name="rak" value="{{ old('rak', $komponen->rak ?? 0) }}" min="0"
                                    class="w-full bg-gray-800 border {{ $errors->has('rak') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-600">no.</span>
                            </div>
                            @error('rak')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="lokasi" class="block text-xs font-medium text-gray-400 mb-1.5">Lot</label>
                            <div class="relative">
                                <input type="number" id="lokasi" name="lokasi" value="{{ old('lokasi', $komponen->lokasi ?? 0) }}" min="0"
                                    class="w-full bg-gray-800 border {{ $errors->has('lokasi') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-600">no.</span>
                            </div>
                            @error('lokasi')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="id_departemen" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Bagian <span class="text-rose-400">*</span>
                            </label>
                            <select id="id_departemen" name="id_departemen"
                                class="w-full bg-gray-800 border {{ $errors->has('id_departemen') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih Bagian —</option>
                                @foreach($departemen as $d)
                                    <option value="{{ $d->id }}" {{ old('id_departemen', $komponen->id_departemen) == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departemen')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">
                                Stok Saat Ini
                                <span class="text-gray-600 font-normal">(via mutasi)</span>
                            </label>
                            <div class="relative">
                                <input type="number" value="{{ $komponen->stok ?? 0 }}" disabled
                                    class="w-full bg-gray-800/40 border border-gray-700/60 text-gray-600 rounded-xl px-3.5 py-2.5 pr-12 text-sm cursor-not-allowed font-mono">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-700" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-gray-700">
                                Ubah via <a href="" class="text-indigo-500 hover:text-indigo-400">Mutasi Barang</a>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-gray-800 bg-gray-900/50 flex items-center justify-between">
                    <a href="{{ route('komponen.index') }}"
                        class="px-4 py-2 rounded-xl border border-gray-700 text-gray-400 hover:text-gray-200 hover:border-gray-600 text-sm font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-semibold rounded-xl px-5 py-2 text-sm transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection