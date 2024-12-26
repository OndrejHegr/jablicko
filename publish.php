<?php

use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

require_once __DIR__ . '/vendor/autoload.php';

const BROKER_HOSTNAME = 'ye9f91ea.ala.eu-central-1.emqxsl.com'; // free broker broker.emqx.io
const BROKER_PORT = 8883;   // free port 1883, 8883 is MQTT over SSL
const BROKER_USERNAME = 'nasoutez_publisher';
const BROKER_PASSWORD = 'Publ1sher.P4ssword';

function mqtt_publish($mqtt_topic, $mqtt_data): void
{
    $mqtt = new MqttClient(BROKER_HOSTNAME, BROKER_PORT, BROKER_USERNAME);
    $connectionSettings  = (new ConnectionSettings)
        ->setUsername(BROKER_USERNAME)
        ->setPassword(BROKER_PASSWORD)
        ->setKeepAliveInterval(60)
        ->setConnectTimeout(3)
        ->setUseTls(true)
        ->setTlsSelfSignedAllowed(true);
    $mqtt->connect($connectionSettings, false);
    //$mqtt->connect();

    // topic - it allows to filter messages
    $mqtt->publish($mqtt_topic, $mqtt_data, 0);

    $mqtt->disconnect();
}

const COLOR_WHITE = '#ffffff';

$competitionId = 1;

$mqtt_topic = 'contest/'.$competitionId;

$data = [
    //'published' => date('Y-m-d H:i:s'),
    'contest_name' => ['left' => 50, 'top' => 50, 'width' => 700, 'height' => 60, 'value' => 'Memoriál Bohuslava Matiáše'],
    'venue_place' => ['left' => 50, 'top' => 110, 'width' => 700, 'height' => 20, 'value' => 'Kolín'],
    'performance_title' => ['left' => 50, 'top' => 820, 'width' => 700, 'height' => 40, 'value' => 'Someone like You'],
    'club_title' => ['left' => 50, 'top' => 860, 'width' => 700, 'height' => 40, 'value' => 'KTS Příbram'],
    'event_title' => ['left' => 50, 'top' => 900, 'width' => 700, 'height' => 40, 'value' => '1. Freestyle (Semifinále)'],
];

$mqtt_data = json_encode($data);
mqtt_publish($mqtt_topic, $mqtt_data);

echo '<pre>';
var_dump($mqtt_data);
echo '</pre>';
echo 'Published';
