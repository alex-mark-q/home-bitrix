<?php

use Bitrix\TagProvider\Integration\UI\EntitySelector;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

return [
    'ui.entity-selector' => [
        'value' => [
            'entities' => [
                [
                    'entityId' => 'strcompany', // Уникальный ID вашей сущности
                    'provider' => [
                        'moduleId' => 'tagprovider', // ID вашего модуля (папка модуля)
                        // 'className' => EntitySelector\StructureCompanyProvider::class
                        'className' => '\\Bitrix\\TagProvider\\Integration\\UI\\EntitySelector\\StructureCompanyProvider'
                    ],
                ],
            ],
            'extensions' => ['tagprovider.entity-selector'],
        ],
        'readonly' => true,
    ]
];
