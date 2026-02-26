@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-950 text-gray-100 font-sans">
        <div class="max-w-2xl mx-auto px-6 py-8">

            <div class="mb-6">
                <a href="{{ route('mutasi.index') }}"
                    class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-300 text-xs transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke History Mutasi
                </a>
                <p class="text-xs uppercase tracking-[0.25em] text-indigo-400 font-semibold mb-0.5">Gudang</p>
                <h2 class="text-2xl font-bold text-white">Tambah Mutasi Barang</h2>
                <p class="text-gray-500 text-xs mt-0.5">Catat transaksi keluar/masuk komponen</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 rounded-xl px-4 py-3 mb-5 flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-400 shrink-0 mt-0.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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

            <form action="{{ route('mutasi.store') }}" method="POST"
                class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
                @csrf

                <div class="px-6 py-4 border-b border-gray-800">
                    <p class="text-sm font-semibold text-gray-200">Detail Transaksi</p>
                    <p class="text-xs text-gray-500 mt-0.5">Isi semua field yang diperlukan</p>
                </div>

                <div class="px-6 py-5 space-y-4">

                    <div>
                        <label for="id_komponen" class="block text-xs font-medium text-gray-400 mb-1.5">
                            Komponen <span class="text-rose-400">*</span>
                        </label>
                        <select id="id_komponen" name="id_komponen"
                            class="w-full bg-gray-800 border {{ $errors->has('id_komponen') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            onchange="updateStokInfo(this)">
                            <option value="">— Pilih Komponen —</option>
                            @foreach($komponen as $k)
                                <option value="{{ $k->id }}" data-stok="{{ $k->stok }}" data-satuan="{{ $k->satuan }}"
                                    data-stok-minimal="{{ $k->stok_minimal }}" data-departemen="{{ $k->departemen_id }}"
                                    {{ old('id_komponen') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_komponen }} ({{ $k->kode_komponen }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_komponen')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror

                        <div id="stok-info"
                            class="hidden mt-2 bg-gray-800/60 border border-gray-700/60 rounded-lg px-3.5 py-2.5 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Stok tersedia</span>
                            <span id="stok-value" class="text-sm font-mono font-semibold text-emerald-400"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="jenis" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Jenis Mutasi <span class="text-rose-400">*</span>
                            </label>
                            <select id="jenis" name="jenis"
                                class="w-full bg-gray-800 border {{ $errors->has('jenis') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih Jenis —</option>
                                <option value="pengambilan" {{ old('jenis') == 'pengambilan' ? 'selected' : '' }}>📥 Pengambilan
                                </option>
                                <option value="internal" {{ old('jenis') == 'internal' ? 'selected' : '' }}>📤 Pemakaian
                                    Internal</option>
                                <option value="retur" {{ old('jenis') == 'retur' ? 'selected' : '' }}>↩️ Retur</option>
                                <option value="repair_kembali" {{ old('jenis') == 'repair_kembali' ? 'selected' : '' }}>🔧
                                    Repair Kembali</option>
                            </select>
                            @error('jenis')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Tanggal <span class="text-rose-400">*</span>
                            </label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                class="w-full bg-gray-800 border {{ $errors->has('tanggal') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('tanggal')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="jumlah" class="block text-xs font-medium text-gray-400 mb-1.5">
                            Jumlah <span class="text-rose-400">*</span>
                        </label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="0"
                            class="w-full bg-gray-800 border {{ $errors->has('jumlah') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono">
                        @error('jumlah')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="id_departemen_asal" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Dari (Asal) <span class="text-rose-400">*</span>
                            </label>
                            <select id="id_departemen_asal" name="id_departemen_asal"
                                class="w-full bg-gray-800 border {{ $errors->has('id_departemen_asal') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih —</option>
                                @foreach($departemen as $d)
                                    <option value="{{ $d->id }}" {{ old('id_departemen_asal') == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departemen_asal')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="id_departemen_tujuan" class="block text-xs font-medium text-gray-400 mb-1.5">
                                Ke (Tujuan) <span class="text-rose-400">*</span>
                            </label>
                            <select id="id_departemen_tujuan" name="id_departemen_tujuan"
                                class="w-full bg-gray-800 border {{ $errors->has('id_departemen_tujuan') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">— Pilih —</option>
                                @foreach($departemen as $d)
                                    <option value="{{ $d->id }}" {{ old('id_departemen_tujuan') == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departemen_tujuan')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-xs font-medium text-gray-400 mb-1.5">
                            Keterangan
                            <span class="text-gray-600 font-normal">(opsional)</span>
                        </label>
                        <textarea id="keterangan" name="keterangan" rows="2" placeholder="Catatan tambahan..."
                            class="w-full bg-gray-800 border {{ $errors->has('keterangan') ? 'border-rose-500' : 'border-gray-700' }} text-gray-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-600 resize-none">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-gray-800 bg-gray-900/50 flex items-center justify-between">
                    <a href="{{ route('mutasi.index') }}"
                        class="px-4 py-2 rounded-xl border border-gray-700 text-gray-400 hover:text-gray-200 hover:border-gray-600 text-sm font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-semibold rounded-xl px-5 py-2 text-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Mutasi
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function updateStokInfo(select) {
            const opt = select.options[select.selectedIndex];
            const panel = document.getElementById('stok-info');
            const valEl = document.getElementById('stok-value');

            if (!opt.value) {
                panel.classList.add('hidden');
                return;
            }

            const stok = parseInt(opt.dataset.stok) || 0;
            const stokMinimal = parseInt(opt.dataset.stokMinimal) || 0;
            const satuan = opt.dataset.satuan || 'unit';

            valEl.textContent = `${stok.toLocaleString('id-ID')} ${satuan}`;
            valEl.className = stok <= stokMinimal
                ? 'text-sm font-mono font-semibold text-rose-400'
                : 'text-sm font-mono font-semibold text-emerald-400';

            panel.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sel = document.getElementById('id_komponen');
            if (sel.value) {
                updateStokInfo(sel);
                updateTujuan(sel);
            }
        });

        function updateTujuan(select) {
            const opt = select.options[select.selectedIndex];
            const tujuanSel = document.getElementById('id_departemen_tujuan');
            const deptId = opt.dataset.departemen;

            const existingHidden = document.getElementById('id_departemen_tujuan_hidden');
            if (existingHidden) existingHidden.remove();

            if (deptId) {
                tujuanSel.value = deptId;
                tujuanSel.setAttribute('disabled', 'disabled');
                const hid = document.createElement('input');
                hid.type = 'hidden';
                hid.name = 'id_departemen_tujuan';
                hid.id = 'id_departemen_tujuan_hidden';
                hid.value = deptId;
                tujuanSel.after(hid);
            } else {
                tujuanSel.removeAttribute('disabled');
            }
        }

        document.getElementById('id_komponen').addEventListener('change', function (e) {
            updateStokInfo(this);
            updateTujuan(this);
        });
    </script>
@endsection