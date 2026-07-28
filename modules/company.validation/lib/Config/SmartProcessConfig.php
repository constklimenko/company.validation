<?php

declare(strict_types=1);

namespace Company\Validation\Config;

final class SmartProcessConfig
{
    public static function get(): array
    {
        return [
            'entityTypeId' => 159,
            'categoryId' => 15,
            'stopResultId' => 3622065,
            'fields' => [
                'result' => 'UF_CRM_4_RESULT',
                'actNumber' => 'UF_CRM_4_ACT_NUMBER',
                'actDate' => 'UF_CRM_4_ACT_DATE',
                'acts' => 'UF_CRM_4_ACTS',
                'photos' => 'UF_CRM_4_PHOTOS',
            ],
        ];
    }
}
