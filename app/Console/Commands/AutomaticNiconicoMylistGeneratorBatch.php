<?php

namespace App\Console\Commands;

use App\Models\AutoGeneratorVideo;
use Illuminate\Console\Command;

class AutomaticNiconicoMylistGeneratorBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NicoMylistAutoGen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic Niconico Mylist Generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->GetStandbyVideo()) {
            return;
        }

        // Start EC2 Instance

        // Login

        while (true) {
            $autoGeneratorVideo = $this->GetStandbyVideo();

            if (!$autoGeneratorVideo) {
                break;
            }

            $autoGeneratorVideo[AutoGeneratorVideo::STATE] = 'active';
            $autoGeneratorVideo->save();

            // Add Video

            $autoGeneratorVideo[AutoGeneratorVideo::STATE] = 'success';
            $autoGeneratorVideo->save();
        }

        // Stop EC2 Instance

        return;
    }

    /**
     * Get Standby Video
     *
     * @return AutoGeneratorVideo|null
     */
    private function GetStandbyVideo(): ?AutoGeneratorVideo
    {
        return AutoGeneratorVideo::select()
            ->where([
                AutoGeneratorVideo::STATE => 'standby'
            ])
            ->first();
    }
}
