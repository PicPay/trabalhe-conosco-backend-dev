<?php

$file = 'app/Sources/users_picpay.csv';

file_put_contents($file, str_replace('Sou,a', 'Souza', file_get_contents($file)));
file_put_contents($file, str_replace('sou,a', 'souza', file_get_contents($file)));
