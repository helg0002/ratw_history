<?php

//
//$curl = curl_init();
//curl_setopt($curl, CURLOPT_URL, 'https://api.tiingo.com/tiingo/crypto/prices?tickers=btcusd&startDate=2017-01-01&resampleFreq=1day&token=9be51bc3655bac1907a9c07d7079fff9563ef039');
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($curl, CURLOPT_FAILONERROR, true);
//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
//$data = curl_exec($curl);
//
//$rate_arr = json_decode($data, true);
////$get = $rate_arr[0]["priceData"];
//
//
//print_r($rate_arr);







set_time_limit(0);

//Инициализация
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://api.tiingo.com/tiingo/crypto/prices?tickers=btcusd&startDate=2017-01-01&resampleFreq=1day&token=9be51bc3655bac1907a9c07d7079fff9563ef039');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FAILONERROR, true);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

$data = curl_exec($curl);
//Проверка
if ($data === false) {
    $error = curl_error($curl);
    $error_no = curl_errno($curl);
    curl_close($curl);
    echo "CURl error: " . $error  . "\n". "Code: " . $error_no ;
} elseif(json_decode($data) == null) {
    echo "Request error: ответ не является json";
    curl_close($curl);
} else {
    conversion_data($data);
    curl_close($curl);
}
function conversion_data($data){
    $outputJSON = json_decode($data, true);
    $getArray = $outputJSON[0]["priceData"];
//Перебор/присваивание значений
    for ($i = 0; $i < count($getArray); $i++) {
        $datetime[$i]["datetime"] = $getArray[$i]["date"];
        $datetime[$i]["price"] = $getArray[$i]["low"];
        $datetimeArray = $datetime;
    }
//Присвоить заголовки/Создать файл

    $headers = ["datetime", "price BTC-USD"];
    $fp = fopen('file.csv', 'w');
    fputcsv($fp, $headers);

    foreach ($datetimeArray as $fiel_csv) {
        fputcsv($fp, $fiel_csv);
    }

    fclose($fp);
}


