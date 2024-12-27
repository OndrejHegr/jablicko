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
const COLOR_BLACK = '#000000';

$competitionId = 1;

$mqtt_topic = 'contest/'.$competitionId;

$clubs = [
    'KTS Příbram',
    'TK Astra Praha',
    'TK Bonstep Hradec Králové',
    'TK Akcent Ostrava'
];

$performances = [
    'Set Fire to the Rain',
    'Skyfall',
    'Hello',
    'Someone Like You',
    'Love In The Dark',
    'Easy on Me',
    'Rolling in the Deep',
    'When We Were Young',
    'Lovesong'
];

$choreographers = [
    'Dominik Vodička',
    'Petr Čadek',
    'Oskar Hes'
];

$ci = rand(0, count($clubs) - 1);
$pi = rand(0, count($performances) - 1);
$chi = rand(0, count($choreographers) - 1);

$data = [
    'performance_title' => [
        'x' => 50,
        'y' => 580,
        'w' => 900,
        'h' => 40,
        'family' => 'cursive',
        'size' => 30,
        'style' => 'normal',
        'weight' => 'normal',
        'align' => 'left',
        'color' => COLOR_BLACK,
        'border' => 0,
        'value' => $performances[$pi]
    ], 'contest_name' => [
        'x' => 50,
        'y' => 50,
        'w' => 900,
        'h' => 60,
        'family' => 'sans-serif',
        'size' => 50,
        'style' => 'normal',
        'weight' => 'bold',
        'align' => 'center',
        'color' => COLOR_BLACK,
        'border' => 0,
        'value' => 'Memoriál Bohuslava Matiáše'
    ], 'venue_place' => [
        'x' => 50,
        'y' => 110,
        'w' => 900,
        'h' => 35,
        'family' => 'serif',
        'size' => 35,
        'style' => 'italic',
        'weight' => 'normal',
        'align' => 'center',
        'color' => '#00ee00',
        'border' => 0,
        'value' => 'Kolín'
    ], 'event_title' => [
        'x' => 50,
        'y' => 550,
        'w' => 900,
        'h' => 30,
        'family' => 'monospace',
        'size' => 25,
        'style' => 'italic',
        'weight' => 'normal',
        'align' => 'left',
        'color' => '#ee0000',
        'border' => 0,
        'value' => '1. Volný tanec'
    ], 'club_title' => [
        'x' => 50,
        'y' => 620,
        'w' => 900,
        'h' => 35,
        'family' => 'sans-serif',
        'size' => 35,
        'style' => 'normal',
        'weight' => 'bold',
        'align' => 'left',
        'color' => COLOR_BLACK,
        'border' => 0,
        'value' => $clubs[$ci]
    ], 'choreographer' => [
        'x' => 50,
        'y' => 655,
        'w' => 900,
        'h' => 35,
        'family' => 'sans-serif',
        'size' => 35,
        'style' => 'normal',
        'weight' => 'bold',
        'align' => 'right',
        'color' => '#0000ff',
        'border' => 0,
        'value' => $choreographers[$chi]
    ]
];

$mqtt_data = json_encode($data);
mqtt_publish($mqtt_topic, $mqtt_data);

echo '<pre>';
var_dump($mqtt_data);
echo '</pre>';
echo 'Published';
