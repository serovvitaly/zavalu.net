<?php

namespace App\Http\Controllers;

use App\SphinxClient;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function getIndex(Request $request)
    {
        sleep(3);

        $query = $request->get('q');

        $cl = new SphinxClient();

        $cl->SetServer('localhost', 9312);
        //$cl->SetConnectTimeout(1);
        //$cl->SetArrayResult(true);
        //$cl->SetMatchMode(SPH_MATCH_ALL);
        $cl->SetRankingMode(SPH_RANK_WORDCOUNT);
        $res = $cl->Query($query, '*');

        if (empty($res) or !array_key_exists('matches', $res)) {
            return [
                'success' => false
            ];
        }

        $matches_ids_arr = array_keys($res['matches']);

        $docs_arr = \DB::table('documents')
            ->whereIn('id', $matches_ids_arr)
            ->get();

        array_walk($docs_arr, function (&$item) use ($query) {
            $item->foo = strpos($item->content, $query);
            $item->content = trim($item->content);
            $item->content = str_limit($item->content, 300);
            $item->content = str_replace($query, '<strong>' . $query . '</strong>', $item->content);
        });

        return [
            'success' => true,
            'method' => 'showSearchResult',
            'data' => view('search_result', ['records' => $docs_arr])->render()
        ];
    }
}
