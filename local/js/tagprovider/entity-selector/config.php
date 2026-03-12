<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\TagProvider\Integration\UI\EntitySelector\StructureCompanyProvider;

// Логируем сам факт обращения к этому конфигу
file_put_contents(
    $_SERVER["DOCUMENT_ROOT"]."/upload/provider/provider_debug.log", 
    "[" . date('Y-m-d H:i:s') . "] JS Extension tagprovider config.php loaded\n", 
    FILE_APPEND
);

if (!Loader::includeModule('tagprovider')) {
    file_put_contents(
        $_SERVER["DOCUMENT_ROOT"]."/upload/provider/provider_debug.log", 
        "[" . date('Y-m-d H:i:s') . "] Error: tagprovider module not included\n", 
        FILE_APPEND
    );
    return [];
}

$userOptions = [
	'dynamicLoad' => true,
	'dynamicSearch' => true,
	'searchFields' => [
		[
			'name' => 'position',
			'type' => 'string',
		],
		[
			'name' => 'email',
			'type' => 'email'
		],
	],
	'searchCacheLimits' => [
		'^[=_0-9a-z+~\'!\\$&*^`|\\#%\\/?{}-]+(\\.[=_0-9a-z+~\'!\\$&*^`|\\#%\\/?{}-]+)*@'
	],
	'badgeOptions' => [
		[
			'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_ON_VACATION_BADGE'),
			'bgColor' => '#b4f4e6',
			'textColor' => '#27a68a',
			'conditions' => [
				'isOnVacation' =>  true,
			],
		],
		[
			'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_INVITED_USER_BADGE'),
			'textColor' => '#23a2ca',
			'bgColor' => '#dcf6fe',
			'conditions' => [
				'invited' =>  true,
			],
		],
	],
	'itemOptions' => [
		'default' => [
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/default-user.svg',
			'link' => '',
			'linkTitle' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_USER_LINK_TITLE'),
		],
		'extranet' => [
			'textColor' => '#ca8600',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/extranet-user.svg',
			'badges' => [
				[
					'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_EXTRANET_BADGE'),
					'textColor' => '#bb8412',
					'bgColor' => '#fff599',
				],
			],
		],
		'email' => [
			'textColor' => '#ca8600',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/email-user.svg',
			'badges' => [
				[
					'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_GUEST_USER_BADGE'),
					'textColor' => '#bb8412',
					'bgColor' => '#fff599',
				],
			],
		],
		'inactive' => [
			'badges' => [
				[
					'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_INACTIVE_INTRANET_USER_BADGE'),
					'textColor' => '#828b95',
					'bgColor' => '#eaebec',
				],
			],
		],
		'integrator' => [
			'badges' => [
				[
					'title' => Loc::getMessage('SOCNET_ENTITY_SELECTOR_INTEGRATOR_USER_BADGE'),
					'textColor' => '#668d13',
					'bgColor' => '#e6f4b9',
				],
			],
		],
		'collaber' => [
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/collaber-user.svg',
			'textColor' => '#19CC45',
			'avatarOptions' => [
				'outline' => '1px solid #19CC45',
				'border' => '2px solid #fff',
				'outlineOffset' => '-1px',
			],
		],
	],
	'tagOptions' => [
		'default' => [
			'textColor' => '#1066bb',
			'bgColor' => '#bcedfc',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/default-tag-user.svg',
		],
		'extranet' => [
			'textColor' => '#a9750f',
			'bgColor' => '#ffec91',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/extranet-user.svg',
		],
		'email' => [
			'textColor' => '#a26b00',
			'bgColor' => '#ffec91',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/email-user.svg',
		],
		'inactive' => [
			'textColor' => '#5f6670',
			'bgColor' => '#ecedef',
		],
		'collaber' => [
			'textColor' => '#1E8D36',
			'bgColor' => '#D4FDB0',
			'avatar' => '/bitrix/js/socialnetwork/entity-selector/src/images/collaber-user.svg'
		],
	]
];

return [
    'js' => 'dist/index.js',   // Убедитесь, что пути соответствуют папке dist внутри вашего расширения
    'css' => 'dist/index.css',
    'rel' => [
        'main.core',
		'sidepanel',
        'ui.entity-selector'
    ],
    'skip_core' => false,
    'settings' => [
        'entities' => [
            [
                'id' => 'strcompany',
                // 'dynamicLoad' => true,
	            // 'dynamicSearch' => true,
                // 'options' => [], 
                'options' => $userOptions,
            ],
        ]
    ],
];
