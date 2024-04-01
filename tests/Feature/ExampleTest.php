<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Klausul;
use Database\Seeders\KlausulSeeder;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM klausul');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_klausul_data(){
        $this->seed(KlausulSeeder::class);

        $klausul = Klausul::all();
        
        
        Log::info(json_encode($klausul, JSON_PRETTY_PRINT));
    }
}
