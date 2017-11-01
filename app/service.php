<?php

use Helper\Import\Import;

define('API_TOKEN', 'LJGRJNRnjrsngnKJRNRG76riuty1119');

$app['import.data.helper'] = function () {
    return new Import();
};