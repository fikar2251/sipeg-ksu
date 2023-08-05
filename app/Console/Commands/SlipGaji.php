<?php

namespace App\Console\Commands;

use App\Models\Gaji;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SlipGaji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slip:gaji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk mengirimkan slip gaji ke masing-masing karyawan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $gaji = Gaji::all();
        // foreach ($gaji as $key => $gajis) {

        // }
        $data = ['test check sound'];
        Mail::raw();

        return Command::SUCCESS;
    }
}
