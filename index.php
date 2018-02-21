<?php
$appid = '8a43ceeacde9e3ff1f67525b1d2de840';
$id_default = '524894';
if (isset($_REQUEST['city'])) {
    $city_id = $_REQUEST['city'];
};
if (empty($city_id)) {
    $city_id = $id_default;
};
$api = file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&appid=" . $appid);
$city_list_file = file_get_contents("city.list");
$decode_api = json_decode($api, true);
$decode_city = json_decode($city_list_file, true);
// Город
$city_name = $decode_api['name'];
// Погода
$weather_desc = $decode_api['weather'][0]['description'];
$pressure = $decode_api['main']['pressure'];
$humidity = $decode_api['main']['humidity'];
$coord_lon = $decode_api['coord']['lon'];
$coord_lat = $decode_api['coord']['lat'];
// Градусы
$temp = $decode_api['main']['temp'];
// Пересчет в градусы
$temp_celsius = $temp - 273;
$temp_celsius = round($temp_celsius, 1). ' C&deg';
// Добавляем +
if ($temp_celsius > 0) {
    $temp_celsius = str_pad($temp_celsius, strlen($temp_celsius)+1, "+", STR_PAD_LEFT);
}
// Иконка погоды
$icon = $decode_api['weather'][0]['icon'];
$icon_url = 'http://openweathermap.org/img/w/' . $icon . '.png';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <title>«Стандартные функции»</title>
    <meta charset="UTF-8"> 
</head>
<body>
    <div>
        <form method="post" enctype="form">
            <select name="city">
                <?php foreach ($decode_city as $item) : ?>
                <option value="<?=$item['id']?>" <?php if ($item['id'] == $city_id) : echo "selected=\"selected\""; endif ?>><?=$item['name']?></option>
                <?php endforeach; ?>
            </select>
            <button>Search</button>
        </form>
        <h1><?=$city_name;?></h1>
        <img src="<?= $icon_url; ?> " alt="">
		<span><?= $temp_celsius; ?></span>
        <div><?= $weather_desc; ?></div>
        <ul>
            <li>Pressure:<?= $pressure; ?> hpa</li>
            <li>Humidity:<?= $humidity; ?> % </li>
            <li>Geo coords:[<?= $coord_lat; ?>, <?= $coord_lon; ?>] </li>
        </ul>
	</div>	
</body>
</html>