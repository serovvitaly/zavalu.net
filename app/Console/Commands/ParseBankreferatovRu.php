<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Flysystem\Exception;

class ParseBankreferatovRu extends Command
{
    const HOST = 'http://www.bankreferatov.ru';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:bankreferatov';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг сайта bankreferatov.ru';

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
        $doc = \DB::connection('mongodb')->collection('bankreferatov_documents')->first();

        $captcha = $this->downloadFileFromPageContent($doc['href2']);
    }

    public function downloadFileFromPageContent($page_url)
    {
        $url = self::HOST . $page_url;
        $page_content = file_get_contents($url);

        preg_match('/src=(\/TMPFILES\/[^\s]+)/', $page_content, $matches);

        if (empty($matches)) {
            return;
        }

        $captcha_img_name = 'bankreferatov_captcha_img/' . str_replace('/', '_', $matches[1]);

        $captcha_img_url = self::HOST . $matches[1];

        $this->info($url);
        $this->info($captcha_img_url);

        try {
            $captcha_img_content = file_get_contents($captcha_img_url);

            \Storage::disk('local')->put($captcha_img_name, $captcha_img_content);

            $this->warn('OK!');
        }
        catch (\ErrorException $e) {

            $this->error($e->getMessage());
        }
        catch (Exception $e) {

            $this->error($e->getMessage());
        }
    }

    /**
     * Парсит все страницы, начиная с первой(получая на ней общее количество страниц)
     * @param $base_url
     * @return array|null
     */
    public function parseAllPagesByUrl($base_url)
    {
        $items_arr = self::getItemsOnPage($base_url);

        if (empty($items_arr)) {
            return null;
        }

        $display_count = 30;

        $pages_count = $items_arr[0]['pages_count'];

        for ($page_key = $display_count + 1; $page_key <= $pages_count * $display_count; $page_key += $display_count) {

            $url = $base_url . '/'.$page_key.'.htm';

            $items_arr = array_merge($items_arr, self::getItemsOnPage($url));
        }

        return $items_arr;
    }

    /**
     * Возвращает список ссылок на Рефераты
     * @param $url
     * @return array
     */
    public static function getItemsOnPage($url)
    {
        $url = self::HOST . $url;
        $page_content = file_get_contents($url);

        preg_match_all('/<tr class=lgraycell><td><a href="([^"]+)" title="([^"]*)">([^<]+)<\/a><\/td><td><script type="text\/javascript">tr\(\'([^\']*)\'\)<\/script><\/td><td><script type="text\/javascript">tr\(\'([^\']*)\'\)<\/script><\/td><td><script type="text\/javascript">d\(\'([^\']+)\', \'([^\']+)\'\)<\/script><\/td><td><script type="text\/javascript">var UNID=\'([^\']+)\';s\(UNID\);addQPhint\(1,UNID\);<\/script><\/td><\/tr>/', $page_content, $ms_arr, PREG_SET_ORDER);

        $pages_count = self::getPagesCountInContent($page_content);

        array_walk($ms_arr, function (& $item, $key) use ($pages_count, $url) {
            $item = [
                'href1' => trim($item[1]),
                'href2' => '/db/GetFile?Open&UNID=' . trim($item[8]) . '&Key=' . trim($item[7]),
                'title' => trim($item[2]),
                'text' => trim($item[3]),
                'type' => trim($item[4]),
                'lang' => trim($item[5]),
                'pages_count' => $pages_count,
                'base_url' => $url
            ];
        });

        \Log::info('Парсинг страницы: ' . $url . ', найдено элементов - ' . count($ms_arr));

        return $ms_arr;
    }

    /**
     * Возвращает количество страниц на разбираемой странице
     * @param $content
     * @return int
     */
    public static function getPagesCountInContent($content)
    {
        preg_match_all('/<a href="[^"]*" title="[^"]*">(\d+)<\/a>/', $content, $matches, PREG_SET_ORDER);

        return (int) last($matches)[1];
    }

    /**
     * Возвращает каталог
     * @return array
     */
    public static function getCatalog()
    {
        $ms_arr = \DB::connection('mongodb')->collection('bankreferatov_catalog')->get();

        if (!empty($ms_arr)) {
            return $ms_arr;
        }

        $url = self::HOST . '/referaty.htm#.V2KG-nYjH0o';
        $page_content = file_get_contents($url);

        preg_match_all('/<td><a href="([^"]+)" title="([^"]+)">([^<]+)<\/a> \(([\d]+)\)<\/td>/', $page_content, $ms_arr, PREG_SET_ORDER);

        array_walk($ms_arr, function (& $item, $key) {
            $item = [
                'href' => trim($item[1]),
                'title' => trim($item[2]),
                'text' => trim($item[3]),
                'count' => (int) $item[4],
            ];
        });

        \DB::connection('mongodb')->collection('bankreferatov_catalog')->insert($ms_arr);

        $ms_arr = \DB::connection('mongodb')->collection('bankreferatov_catalog')->get();

        return $ms_arr;
    }
}
