<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\WebScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;

class ArticleController extends Controller
{
    private $webScraper;

    public function __construct(WebScraper $webScraper)
    {
        $this->webScraper = $webScraper;
    }

    public function create()
    {
        try {
            $links_data = $this->webScraper->scrape_pinboard();
                if ($links_data['success']) {
                    foreach ($links_data['data'] as $link) {
                        Article::create($link);
                    }

                    $res = [
                        'id' => 0,
                        'info' => 'Found and saved: '.count($links_data['data']).' Links.'
                    ];

                    return successResponse('app services', $res, false);
                } else {
                    throw new Exception();                    
                }
        } catch(\Exception $e) {
            $e_title = 'Error Retrieving Links from Pinboard';
            $e_message = $e->getMessage();
            Log::error($e_title . ': ' . $e_message);
            return errorResponse($e_title, $e_message);
        }
    }

    public function index()
    {
        $articles = Article::all();
        return successResponse('articles', $articles, true);
    }

    public function findArticlesByTags(Request $request, $queryTags)
    {
        $tags = explode(',', $queryTags);
        $articles = [];

        if (count($tags) === 1) {
            $query = Article::query();

            foreach ($tags as $tag) {
                $query->orWhere('tags', 'LIKE', "%{$tag}%");
            }

            $articles = $query->get();
        } else {
            $articles = Article::all()->filter(function ($tag) use ($tags) {
                $matches = 0;
                foreach ($tags as $searchTag) {
                    if (stripos($tag->tags, $searchTag) !== false) {
                        $matches ++;
                        if ($matches >= 2) {
                            return true;
                        }
                    }
                }
                return false;
            });
        }

        return successResponse('articles', $articles, true);
    }
}
