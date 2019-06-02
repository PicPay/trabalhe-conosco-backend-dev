<?php
$config = array(
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    'db' => array(
        'host' => 'db',
        'user' => 'picpay',
        'pass' => 'picpaypass',
        'dbname' => 'picpay_db'
    ),
    'api' => array(
        'pagination' => array(
            'per_page' => 15
        ),
        'authentication' => array(
            'user' => 'picpay',
            'password' => 'picpaypass'
        )
    )
);
