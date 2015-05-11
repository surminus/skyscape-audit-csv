<?php

$file = $argv[1];
$data = file_get_contents($file) or die("File must exist!\n");
$array = json_decode($data, true);
