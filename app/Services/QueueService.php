<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\QueueHistory;
use Illuminate\Support\Facades\Auth;

class QueueService
{
    public static function cancelQueue(Queue $queue, $userId = null)
    {
        QueueHistory::create([
            'queue_id'    => $queue->id,
            'user_id'     => $userId ?? $queue->user_id,
            'doctor_id'   => $queue->doctor_id,
            'patient_id'  => $queue->patient_id,
            'tgl_periksa' => $queue->tgl_periksa,
            'start_time'  => $queue->start_time,
            'end_time'    => $queue->end_time,
            'keterangan'  => $queue->keterangan,
            'status'      => 'batal',
            'is_booked'   => $queue->is_booked,
        ]);

        $queue->delete();
    }
}
