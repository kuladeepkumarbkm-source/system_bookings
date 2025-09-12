<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Currency;

class FxUpdate extends Command
{
    protected $signature = 'fx:update';
    protected $description = 'Load storage/app/mocks/fx.json into currencies table';

    public function handle(): int
    {
        $path = 'mocks/fx.json';
        if (! Storage::disk('local')->exists($path)) {
            $this->error('mocks/fx.json not found.');
            return 1;
        }

        $json = Storage::disk('local')->get($path);
        $data = json_decode($json, true);

        if (! $data || ! isset($data['rates'])) {
            $this->error('invalid fx.json');
            return 1;
        }

        // Ensure INR base exists
        Currency::updateOrCreate(['code' => 'INR'], ['value' => 1, 'updated_at' => now()]);

        foreach ($data['rates'] as $code => $value) {
            Currency::updateOrCreate(
                ['code' => $code],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        $this->info('Currencies updated.');
        return 0;
    }
}
