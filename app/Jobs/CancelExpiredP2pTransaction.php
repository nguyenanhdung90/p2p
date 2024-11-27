<?php

namespace App\Jobs;

use App\Models\P2pTransaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psy\Command\Command;

class CancelExpiredP2pTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $tranId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $tranId)
    {
        $this->tranId = $tranId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $p2pTransaction = P2pTransaction::find($this->tranId);
        if (!$p2pTransaction) {
            printf("Not found Cancel Transaction p2p id: %s", $this->tranId);
            return Command::SUCCESS;
        }
        if ($p2pTransaction->status !== P2pTransaction::INITIATE) {
            printf("New status of this transaction p2p: %s", $p2pTransaction->status);
            return Command::SUCCESS;
        }
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $p2pTransaction->start_process);
        $diff = Carbon::now()->diffInSeconds($startTime);
        if ($diff >= $p2pTransaction->expired_process) {
            $p2pTransaction->status = P2pTransaction::CANCEL;
            $p2pTransaction->save();
            printf("Cancel transaction p2p id: %s", $this->tranId);
            return Command::SUCCESS;
        } else {
            printf("Time is not enough to cancel, implement at the next time, id: %s", $this->tranId);
            $timeNextTurn = $p2pTransaction->expired_process - $diff + 5;
            $this->release($timeNextTurn);
        }
    }
}
