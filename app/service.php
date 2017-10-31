<?php

define('API_TOKEN', 'LJGRJNRnjrsngnKJRNRG76riuty1119');

$app['import.data.helper'] = function () {
    return new \Helper\Import\Import();
};