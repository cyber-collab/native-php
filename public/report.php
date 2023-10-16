<?php
require_once __DIR__ . '/../vendor/autoload.php'; // include autoload
use App\Helper\RacerReport;
$report = new RacerReport( '../files/abbreviations.txt', '../files/end.log' );
$arrayTopRacers = $report->getTopRacers();
$arrayLosersRacers = $report->getLosersRacers();
$index = 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
</head>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>Team</th>
        <th>Time</th>
    </tr>
    <?php foreach ($arrayTopRacers as $racer) : ?>
        <tr>
            <td> <?php echo $index++ . '.' ?> </td>
            <td> <?php echo $racer['name'] ?> </td>
            <td> <?php echo $racer['team'] ?> </td>
            <td> <?php echo gmdate('H:i:s', $racer['time']) ?> </td>
        </tr>
    <?php endforeach; ?>
</table>
<table>
    <hr>
    <?php foreach ($arrayLosersRacers as $racer) : ?>
        <tr>
            <td> <?php echo $index++ . '.' ?> </td>
            <td> <?php echo $racer['name'] ?> </td>
            <td> <?php echo $racer['team'] ?> </td>
            <td> <?php echo gmdate('H:i:s', $racer['time']) ?> </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
