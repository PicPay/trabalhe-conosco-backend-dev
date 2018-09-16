<?php

$manager->executeCommand('database', new \MongoDB\Driver\Command(["drop" => "collection"]));
?>