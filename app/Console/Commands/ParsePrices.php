<?php

namespace App\Console\Commands;

use App\Models\ProductModel;
use Illuminate\Console\Command;

class ParsePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг каталога товаров';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_path = base_path() . '/products.csv';

        $content = file_get_contents($file_path);

        $rows_arr = explode("\n", $content);

        foreach ($rows_arr as $row) {

            $fields_arr = explode(';', $row);

            ProductModel::create([
                'article' => $fields_arr[0],
                'brand' => $fields_arr[1],
                'category' => $fields_arr[2],
                'title' => $fields_arr[3],
                'weight' => str_replace(',', '.', $fields_arr[4]),
                'price' => str_replace(',', '.', $fields_arr[5]),
            ]);

            echo '.';
        }
        echo "\n";
    }
}
