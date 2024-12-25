<?php
use PhpMqtt\Client\MqttClient;

require_once __DIR__ . '/vendor/autoload.php';

const BROKER_HOSTNAME = 'broker.emqx.io';
const BROKER_PORT = 1883;
const BROKER_PUBLISHER = 'nasoutez-publisher';

$competitionId = 1;

function mqtt_publish($mqtt_topic, $mqtt_data): void
{
    $mqtt = new MqttClient(BROKER_HOSTNAME, BROKER_PORT, BROKER_PUBLISHER);
    $mqtt->connect();

    // topic - it allows to filter messages
    $mqtt->publish($mqtt_topic, $mqtt_data, 0);

    $mqtt->disconnect();
}

$mqtt_topic = 'nasoutez/contest/'.$competitionId;

// simple data
$data = [
    'published' => date('Y-m-d H:i:s'),
    'contest_name' => 'Memoriál Bohuslava Matiáše',
    'venue_place' => 'Kolín',
    'category_name' => '1. Freestyle (Semifinále)',
    'performance_title' => 'Someone like You',
    'club' => 'TK Astra Praha',
    'choreographer' => 'Ing. Miroslav Brožovský'
];

// complex data - it seems the transfer does not work
/*$data = [
    'published' => date('Y-m-d H:i:s'),
    'contest_name' => ['left' => 50, 'top' => 50, 'width' => 900, 'height' => 80, 'value' => 'Memoriál Bohuslava Matiáše'],
    'venue_place' => ['left' => 110, 'top' => 50, 'width' => 900, 'height' => 20, 'value' => 'Kolín'],
    'performance_title' => ['left' => 50, 'top' => 580, 'width' => 900, 'height' => 40, 'value' => 'Someone like You'],
    'club_title' => ['left' => 50, 'top' => 620, 'width' => 900, 'height' => 40, 'value' => 'TK Astra Praha'],
    'event_title' => ['left' => 50, 'top' => 660, 'width' => 900, 'height' => 40, 'value' => '1. Freestyle (Semifinále)'],
];*/

$mqtt_data = json_encode($data);
mqtt_publish($mqtt_topic, $mqtt_data);

echo '<pre>';
var_dump($mqtt_data);
echo '</pre>';
echo 'Published';
