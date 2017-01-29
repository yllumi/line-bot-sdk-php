<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'WE7EIboieMDKrfQrMfprsTSgaqN0CNPRuOLzpjP1/xb8Ue07baRz44srl9dfYpuS6VMUEZZAqKUfoNw8rkZwgaoFyjtcIs7iRLMzT2ti4HAlxSiHkATF/zQzG2dkbif9dZbZnESMxygwoR1BdAwjCgdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'a15cfa78375737ebe90493c3c6374c48';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $message['text']
                            )
                        )
                    ));
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};

echo "sipsip";

$db = new mysqli('localhost', 'tebakode', 'bismillah', 'localdb');

/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($db->connect_error) {
    die('Connect Error (' . $db->connect_errno . ') '
            . $db->connect_error);
}

/*
 * Use this instead of $connect_error if you need to ensure
 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
 */
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Success... ' . $db->host_info . "\n";

// $data = json_encode(['satu','dua']);
$data = json_encode($client->parseEvents());
$result = $db->query("INSERT INTO events (events) VALUES ('$data')");

$db->close();