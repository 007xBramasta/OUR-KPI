<?php

namespace App\Jobs;

use App\Models\Klausul;
use App\Models\KlausulItem;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // create new laporan
        try {
            for ($i = 1; $i <= 12; $i++) {
                $this->user->laporan()->create([
                    'departements_id' => $this->user->departements_id,
                    'created_at' => Carbon::create(year: date('Y'), month: $i),
                    'updated_at' => Carbon::create(year: date('Y'), month: $i),
                ]);
            }

            $userLaporans = Laporan::where('user_id', "=", $this->user->id)->get();
            $klausul_items = KlausulItem::all();
            foreach ($userLaporans as $laporan) {
                // buat penilaian untuk setiap klausul item dari laporan di atas
                foreach ($klausul_items as $item) {
                    Penilaian::create([
                        'laporan_id' => $laporan->laporan_id,
                        'klausul_item_id' => $item->id
                    ]);
                }
            }
        } catch (\Throwable $th) {
            info($th->getMessage());
        }
    }
}
