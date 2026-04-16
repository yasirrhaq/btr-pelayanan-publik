<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Permohonan;
use App\Models\WorkflowLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkflowService
{
    public function transition(Permohonan $permohonan, string $newStatus, ?string $catatan = null): Permohonan
    {
        if (!$permohonan->canTransitionTo($newStatus)) {
            throw new \InvalidArgumentException(
                "Tidak dapat mengubah status dari '{$permohonan->status}' ke '{$newStatus}'."
            );
        }

        return DB::transaction(function () use ($permohonan, $newStatus, $catatan) {
            $oldStatus = $permohonan->status;

            $permohonan->update([
                'status'   => $newStatus,
                'progress' => Permohonan::STATUS_PROGRESS[$newStatus] ?? $permohonan->progress,
            ]);

            if ($newStatus === Permohonan::STATUS_PELAKSANAAN && !$permohonan->tanggal_mulai) {
                $permohonan->update(['tanggal_mulai' => now()]);
            }
            if ($newStatus === Permohonan::STATUS_SELESAI) {
                $permohonan->update(['tanggal_selesai' => now(), 'progress' => 100]);
            }

            WorkflowLog::create([
                'permohonan_id' => $permohonan->id,
                'dari_status'   => $oldStatus,
                'ke_status'     => $newStatus,
                'actor_id'      => Auth::id(),
                'catatan'       => $catatan,
            ]);

            $label = Permohonan::STATUS_LABELS[$newStatus] ?? $newStatus;
            Notifikasi::create([
                'user_id'       => $permohonan->user_id,
                'permohonan_id' => $permohonan->id,
                'judul'         => "Status Permohonan Diperbarui",
                'pesan'         => "Permohonan #{$permohonan->nomor_pl} telah berubah status menjadi: {$label}.",
                'tipe'          => $newStatus === Permohonan::STATUS_DITOLAK ? 'danger' : 'info',
            ]);

            return $permohonan->fresh();
        });
    }
}
