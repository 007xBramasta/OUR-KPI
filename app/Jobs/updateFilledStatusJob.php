<?php

namespace App\Jobs;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class updateFilledStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Laporan $laporan)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count  = $this->laporan->penilaians()->where('aktual', '=', 0)->count();
        if ($count == 0) {
            $this->laporan->update([
                'filled' => 1
            ]);
        } else if($count > 0) {
            $this->laporan->update([
                'filled' => 0
            ]);
        }
    }
}
