<!-- newsapi.org -->

<?php

class NewsApp{
        private $api;
        public $displayed = 0;
        public function __construct($api){
            $this->api = $api;
        }
        public function showTopHeadlines(){
            $headlines = $this->api->getTopHeadlines();
            // var_dump() used to debug API
            // var_dump($headlines);
            foreach($headlines as $headline){
                // strip_tags used to remove ul li etc from strings
                $urlToImage = htmlspecialchars($headline['urlToImage']);
                $author = htmlspecialchars($headline['author']);
                $title = htmlspecialchars(strip_tags($headline['title']));
                $content = htmlspecialchars(strip_tags($headline['content']));
                $url = htmlspecialchars($headline['url']);
                $sourceName = htmlspecialchars($headline['source']['name']);
                $publishedAt = new DateTime($headline['publishedAt']);
                //Check for certain NULL values and dont display because I want clean cards
                if($urlToImage == NULL || $content == NULL){
                    continue;
                }
                elseif($this->displayed == 0){
                     echo "
                    <section id='breaking-news-section'>
                        <div class='breaking-news-card' title='{$title}'>
                                <div class='breaking-img-container'>
                                    <a href='{$url}' title='{$title}' target='_blank' rel='noopener noreferrer'>
                                        <img src='{$urlToImage}' alt='Image for {$title}'>
                                    </a>
                                </div>
                                <div class='breaking-title-container'>
                                    <h3>{$title}</h3>
                                </div>
                                <div class='breaking-content-container'>
                                    <p class='breaking-content'>{$content} <a href='{$url}' title='{$title}' target='_blank' rel='noopener noreferrer' class='bold nounder'>Full Article</a></p>
                                    <p class='source'>Source: {$sourceName}</p>
                                    <p class='author'>Author: {$author}</p>
                                    <p class='published'>Published: {$publishedAt->format('F j, Y g:i A')}</p>
                                </div>
                        </div>
                    </section>";
                    $this->displayed++;
                    echo "<section id='top-headlines-section'>";
                    echo "<h2 class='top-headlines-h2'>Top Headlines</h2>";
                    echo "<div class='top-headlines'>";
                }
                else{
                    // Create Card and increment displayed
                    echo "
                    <a class='news-card' href='{$url}' title='{$title}' target='_blank' rel='noopener noreferrer'>
                            <div class='img-container'>
                                <img src='{$urlToImage}' alt='Image for {$title}'>
                            </div>
                            <div class='card-container'>
                                <h3>{$title}</h3>
                                <p>{$content}</p>
                                 <p class='bold blue'>Full Article</p>
                            </div>
                    </a>";
                    $this->displayed++;
                }
                // break foreach when desired cards are displayed
                if($this->displayed == 9){
                    break;
                }
            }
            // Close tags
                    echo "</div>";
                    echo "</section>";
        }
    }
?>