<?php
    require_once "./config.php";
    require_once "./NewsApi.php";
    require_once "./NewsApp.php";
    $api = new NewsApi(API_KEY,BASE_URL);
    $newsApp = new NewsApp($api);
?>

<!-- Simple API request for a random quote of the day does not require API Key very limited use -->
<?php
    $ch = curl_init("https://zenquotes.io/api/random");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    // Used to test
    // var_dump($data);
    // Ensure no HTML tags make it through sanitation as a precaution
    $quote = htmlspecialchars(strip_tags($data[0]['q']));
    $author = htmlspecialchars(strip_tags($data[0]['a']));
    // This will be displayed if API requests limit is reached
    $defaultQuote = "Fake news and rumors thrive online because few verify what's real and always bias towards content that reinforces their own biases.";
    $defaultAuthor = "Ryan Higa";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="robots" content="noindex,nofollow">
    <meta charset="UTF-8">
    <meta name="description" content="Latest news and headlines from NewsHub">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsHub | Home</title>
</head>
<body>
    <header>
        <!-- Only changes link to hamburger due to this application being a single page -->
        <nav class="responsive-nav">
             <div class="logo-container">
                <a href="#">
                    <img class="logo" src="./assets/img/logo.png" alt="NewsHub">                
                </a>
             </div>
            <menu>
                <!-- Links added for a more flushed out page look but useless -->
                <li><a href="#" class="hover-link">Home</a></li>
                <li><a href="#" class="hover-link">Breaking News</a></li>
                <li><a href="#" class="hover-link">Search</a></li>
                <li><a href="#" class="hover-link">About Us</a></li>
                <li><a href="#" class="hover-link">Careers</a></li>
            </menu>
            <div class="menu-svg">
                <img src="./assets/svg/hamburger.svg" alt="">
            </div>
        </nav>
    </header>
    <main class="index-main">
        <h1 class="breaking-news-h1">Breaking News</h1>
        <?php
            $newsApp->showTopHeadlines();
        ?>
    </main>
    <footer>
        <div class="footer-links">
            <a href="#" class="hover-link bold">Careers</a>
            <a href="#" class="hover-link bold">About Us</a>
            <a href="#" class="hover-link bold">Mission Statement</a>
            <a href="#" class="hover-link bold">Legal</a>
            <a href="#" class="hover-link bold">Contact Us</a>
        </div>
        <div class="quote-of-day">
        <?php
        // Check to see if API limit is reached by checking the author
        if($author !="zenquotes.io"){
            echo "
            <div>
            <p class='quote'>\"{$quote}\"</p>
            <p class='italic'>- {$author}</p>
            </div>";
        } else {
            echo "
            <div>
            <p class='quote'>\"{$defaultQuote}\"</p>
            <p class='italic'>-{$defaultAuthor}</p>
            </div>";
        }

        ?>
        </div>
        <div class="social-container">
            <div class="logo-container-footer">
                <a href="#">
                    <img src="./assets/img/logo.png" alt="">
                </a>
            </div>
            <div class="socials-container">
                <div class="social-svg-container">
                    <a href="">
                        <img src="./assets/svg/facebook.svg" alt="">
                    </a>
                </div>
                <div class="social-svg-container">
                    <a href="#">
                        <img src="./assets/svg/twitter.svg" alt="">
                    </a>
                </div>
                <div class="social-svg-container">
                    <a href="">
                        <img src="./assets/svg/insta.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="address">
                <p>1534 News Lane</p>
                <p>Barrie, On</p>
                <p>L4N 3E9</p>
            </div>
        </div>
        <p class="copyright">© 2025 NewsHub. All rights reserved.</p>
    </footer>
</body>
</html>