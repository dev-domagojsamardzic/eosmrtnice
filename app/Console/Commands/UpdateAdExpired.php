<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateAdExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:update-ad-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Ad expired flag';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $ads = Ad::query()
            ->where('expired', 0)
            ->where('valid_until', '<', now()->format('Y-m-d H:i:s'))
            ->get();

        foreach ($ads as $ad) {
            $ad->expired = true;
            $ad->active = false;
            $ad->save();
        }

        return Command::SUCCESS;
    }
}
