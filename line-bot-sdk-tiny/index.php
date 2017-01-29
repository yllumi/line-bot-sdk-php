<?php

echo "begin \n";

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
$result = $db->query("SELECT * FROM users");
$data = $result->fetch_array();

echo "<pre>";
print_r($data);
echo "</pre>";

$db->close();