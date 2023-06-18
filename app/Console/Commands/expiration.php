<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the Serial_Code has been Expired every year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //////////////////15-6-2023 > 15-6-2024
        Book::where('created_at', '>', now()->addYear())->update(['serial_code' => \Str::uuid()]);
    }
}
