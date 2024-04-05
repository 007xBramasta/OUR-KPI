<?php

namespace App\Jobs;

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

/**
 * @author Marselinus Harson Rewo
 * @email marselinus.hr@gmail.com
 * @github marselhr
 */
class CreateMonthlyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $users = User::where('role', '=', 'karyawan')->get();
        $klausul_items = KlausulItem::all();

        foreach($users as $user ){
            $laporan = Laporan::create([
                'user_id' => $user->id,
                'departements_id' => $user->departements_id
            ]);

            foreach($klausul_items as $klausul_item){
                Penilaian::create([
                    'klausul_item_id' => $klausul_item->id,
                    'laporan_id' => $laporan->laporan_id
                ]);
            }
        }
    }
}
