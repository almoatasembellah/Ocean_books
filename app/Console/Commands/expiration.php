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
        //I have two tables the first one called books, and it has column serial_code,  the second table called serials and has 3 columns: material_code, is_expired (datatype:TInyInteger) and foreignID (book_id)
        //I need to make the value of the material_code column equals to the value of the serial_code and check if the code is expired after one year
        //////////////////15-6-2023 > 15-6-2024
        Book::where('created_at', '>', now()->subYear())->update(['serial_code' => \Str::uuid()]);
    }
    //* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
}
