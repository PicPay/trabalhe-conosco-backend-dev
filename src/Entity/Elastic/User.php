<?php

namespace App\Entity\Elastic;

/**
 * Class User
 *
 * @package App\Entity\Elastic
 */
class User
{

    const TYPE = 'user';

    const PRIORITY_DEFAULT = 999999;

    public static function getProperties()
    {
        return [
            "properties" => [
                "name" => [
                    "type" => "keyword",
                    "normalizer" => "full_text_lowercase"
                ],
                "username" => [
                    "type" => "keyword"
                ],
                "priority" => [
                    "type" => "long"
                ]
            ]
        ];
    }

}
