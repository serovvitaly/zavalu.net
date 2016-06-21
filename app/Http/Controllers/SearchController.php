<?php

namespace App\Http\Controllers;

use App\SphinxClient;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = $request->get('q');

        $cl = new SphinxClient();

        $cl->SetServer('localhost', 9312);
        //$cl->SetConnectTimeout(1);
        //$cl->SetArrayResult(true);
        //$cl->SetMatchMode(SPH_MATCH_ALL);
        $cl->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
        $res = $cl->Query($query, '*');

        if (empty($res) or !array_key_exists('matches', $res)) {
            return [
                'success' => false
            ];
        }

        $docs_arr = \DB::table('documents')
            ->whereIn('id', $res['matches'])
            ->get();

        array_walk($docs_arr, function (& $item) use ($query) {
            $item->foo = strpos($item->content, $query);
            //unset($item->content);
        });

        return [
            'success' => true,
            'method' => 'showSearchResult',
            'data' => view('search_result', ['records' => $docs_arr])->render()
        ];
    }
}
