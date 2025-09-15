<!-- newsapi.org -->

<?php

class NewsApi{
    private $apiKey;
    private $baseUrl;
    public function __construct($apiKey,$baseUrl){
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }
    private function request($endpoint){
            $url = $this->baseUrl . $endpoint . "?country=us&apiKey=" . $this->apiKey;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            // Required to interact with newsApi
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'User-Agent: MyNewsApp/1.0'
                ]);
            $response = curl_exec($ch);
            // get cURL error number and human readable code for debugging
            if (curl_errno($ch)) {
                $errorCode = curl_errno($ch);
                $errorMessage = curl_error($ch);
                // 502 is the most accurate code because we are hitting an external API
                http_response_code(502); 
                throw new Exception("cURL Error [{$errorCode}]: {$errorMessage}");
            }
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // var_dump used to check status code while developing
            // var_dump($status);
            curl_close($ch);
            if($status == 404) {
                throw new Exception("{$status} endpoint error");
            }
            $data = json_decode($response, true);
            // Added protection to check if $data is empty to ensure proper error logging
            if(empty($data)){
                throw New Exception ("No Data Retrieved.");
            }
            //Check if status is not ok, show status message for debug
            if($data['status'] != "ok") {
                throw new Exception ("Error: ". $data['message']);
            }
            return $data;
        }
    public function getTopHeadlines(){
            try {
                $data = $this->request("top-headlines");
                // var_dump used to debug API
                // var_dump($data['articles']);
                return $data['articles'] ?? [];
            } catch (Exception $e) {
                echo "
                    <p class='error'>API Error!</p>
                    <p class='error'> ". $e->getMessage() ."</p>"
                ;
                return [];
            }
        }
    }