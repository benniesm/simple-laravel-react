<?php
    namespace App\Services;

    use Illuminate\Support\Facades\Http;
    use Symfony\Component\BrowserKit\HttpBrowser;
    use Illuminate\Support\Facades\Log;

    class WebScraper
    {
        public function scrape_pinboard()
        {
            $client = new HttpBrowser;
    
            // Load the website
            $url = config('constants.external_links.pinboard_url');
            $pinboard = $client->request('GET', $url);

            // Retrieve bookmarks from element with id main_column
            $main_col = $pinboard->filter('#main_column > #bookmarks');
            $articles = $main_col->filter('.bookmark')->each(function ($node) use ($client) {
                return $node->filter('.display')->each(function ($article) use ($client) {
                    $has_needed_tags = false;
                    $needed_tags = config('constants.needed_tags');
                    $found_tags = $article->children('.tag')->each(function ($child) {
                        return $child->text();
                    });
    
                    foreach ($needed_tags as $n_tag) {
                        if (in_array($n_tag, $found_tags)) {
                            $has_needed_tags = true;
                            break;
                        }
                    }
    
                    if ($has_needed_tags) {
                        $url_of_article = $article->filter('.bookmark_title')->attr('href');
                        $req = $client->request('GET', $url_of_article);
                        $url_is_valid = $client->getInternalResponse()->getStatusCode();
    
                        return [
                            'url' => $url_of_article,
                            'title' => $article->filter('.bookmark_title')->text(),
                            'comment' => $article->filter('.description')->text(),
                            'tags' => implode(',', $found_tags),
                            'url_status' => $url_is_valid == 200 ? 1 : 0
                        ];
                    }
                });
            });
            
            $results = [];
            foreach ($articles as $article) {
                if ($article[0]) {
                    array_push($results, $article[0]);
                }
            }
            return ['success' => true, 'data' => $results];            
        }
    }