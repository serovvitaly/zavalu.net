<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VkReferats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:docs.search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Вконтакте API. Возвращает результаты поиска по документам.';

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

        $query = 'реферат';

        $params_arr = [
            'v' => '5.52',
            //'access_token' => '',
            'q' => $query,
        ];

        $url = 'https://api.vk.com/method/docs.search?' . http_build_query($params_arr);

        $this->info($url);

        $json_str = file_get_contents($url);

        $json = json_decode($json_str);

        print_r($json);
    }
}
