<?php

namespace App\Entity\Elastic;

/**
 * Class PicPay
 *
 * @package App\Entity\Elastic
 */
class PicPay
{
    const INDEX = 'pic_pay';

    public static function getSettings()
    {
        return [
            'analysis' => [
                'normalizer' => [
                    'full_text_lowercase' => [
                        'type' => 'custom',
                        'filter' => ['lowercase']
                    ]
                ]
            ]
        ];
    }

}