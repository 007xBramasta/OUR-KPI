<?php

namespace App\Jobs;

use App\Models\Klausul;
use App\Models\KlausulItem;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateNewUserReport implements ShouldQueue // di panggil saat user register
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected User $user)
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
        // create new laporan
        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'departements_id' => $this->user->departements_id,
        ]);

        // get all klausul
        $klausul_items = KlausulItem::all();

        foreach ($klausul_items as $item) {
            Penilaian::create([
                'laporan_id' => $laporan->laporan_id,
                'klausul_item_id' => $item->id,
            ]);
        }
    }
}
