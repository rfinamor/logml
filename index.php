<?php

$site_id = $_GET['site_id']?: "MLA";
$seller_id = $_GET['seller_id'];

//https://api.mercadolibre.com/sites/MLA/search?seller_id=179571326



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.mercadolibre.com/sites/$site_id/search?seller_id=$seller_id" ,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));

$response = json_decode(curl_exec($curl),true);

$results= json_encode($response["results"]);
curl_close($curl);

$log = "";
foreach ($response["results"] as $item){
    $categoryId = $item["category_id"];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.mercadolibre.com/categories/$categoryId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $category = json_decode(curl_exec($curl),true);
    $log .= $item["id"] ." " .$item["title"] ." " .$item["category_id"] ." " .$category["name"] .PHP_EOL;


}
file_put_contents("log.txt",$log);

$content = file_get_contents ("log.txt");
header('Content-Disposition: attachment; filename='.basename('log.txt'));
echo $content;



