<?php

namespace App\Observers;

use App\Models\MasterKomponen;
use App\Models\MutasiBarang;

class MutasiBarangObserver
{
    /**
     * Handle the MutasiBarang "created" event.
     */
    public function created(MutasiBarang $mutasi): void
    {
        $komponen = $mutasi->komponen;
        
        if ($mutasi->isMasuk()) {
            // Jenis masuk: pengambilan, retur, repair_kembali - stok bertambah
            $komponen->increment('stok', $mutasi->jumlah);
        } else {
            // Jenis keluar: internal - stok berkurang
            // Cek stok untuk mencegah minus
            if ($komponen->stok >= $mutasi->jumlah) {
                $komponen->decrement('stok', $mutasi->jumlah);
            } else {
                // Jika stok tidak cukup, hapus mutasi dan throw error
                $mutasi->delete();
                throw new \Exception("Stok tidak cukup. Stok tersedia: {$komponen->stok}, diminta: {$mutasi->jumlah}");
            }
        }
    }

    /**
     * Handle the MutasiBarang "deleted" event.
     */
    public function deleted(MutasiBarang $mutasi): void
    {
        $komponen = $mutasi->komponen;
        
        // Rollback stok
        if ($mutasi->isMasuk()) {
            $komponen->decrement('stok', $mutasi->jumlah);
        } else {
            $komponen->increment('stok', $mutasi->jumlah);
        }
    }

    /**
     * Handle the MutasiBarang "restored" event.
     */
    public function restored(MutasiBarang $mutasi): void
    {
        $komponen = $mutasi->komponen;
        
        // Restore stok
        if ($mutasi->isMasuk()) {
            $komponen->increment('stok', $mutasi->jumlah);
        } else {
            $komponen->decrement('stok', $mutasi->jumlah);
        }
    }
}
