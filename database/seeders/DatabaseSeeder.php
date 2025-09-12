<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
// use App\Models\DB;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            UsersTableSeeder::class,
        ]);

        // Load initial FX from storage mocks
        $json = Storage::disk('local')->get('mocks/fx.json');
        $obj = json_decode($json, true);
        if ($obj && isset($obj['rates'])) {
            \DB::table('currencies')->insertOrIgnore([
                ['code'=>'INR','value'=>1,'updated_at'=>now()],
                ['code'=>'USD','value'=>$obj['rates']['USD'] ?? 0.012,'updated_at'=> now()],
            ]);
        }
    }
}
