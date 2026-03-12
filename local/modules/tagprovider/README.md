
# Модуль tagprovider: провайдер данных «Структура компании»

Модуль добавляет в ui.entity-selector новую сущность strcompany для работы со структурой компании. Позволяет выбирать отделы, сотрудников или комбинировать оба варианта.

# Архитектура
## 1. Регистрация провайдера (.settings.php)
Файл .settings.php в корне модуля объявляет сущность и связывает её с классом-провайдером.

```
<?php
// .settings.php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

return [
    'ui.entity-selector' => [
        'value' => [
            'entities' => [
                [
                    'entityId' => 'strcompany',
                    'provider' => [
                        'moduleId' => 'tagprovider',
                        'className' => '\\Bitrix\\TagProvider\\Integration\\UI\\EntitySelector\\StructureCompanyProvider'
                    ],
                ],
            ],
            'extensions' => ['tagprovider.entity-selector'],
        ],
        'readonly' => true,
    ]
];
```

## 1. Класс-провайдер


## StructureCompanyProvider наследует \Bitrix\UI\EntitySelector\BaseProvider и реализует методы для загрузки данных:
- isAvailable() — проверка доступа;
- getItems(array $ids) — возвращает элементы по идентификаторам;
- getSelectedItems(array $ids) — для предварительно выбранных элементов;
- fillDialog() — заполняет диалог начальными данными;
- getChildren() — загружает сущности;
- doSearch() — поиск.
## JS-расширение tagprovider.entity-selector
- config.php — конфигурация расширения (подключает JS/CSS, задаёт глобальные настройки сущности).
- bundle.config.js — настройки сборки (если используется).
Пример config.php:
```
<?php
// install/js/entity-selector/config.php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!Loader::includeModule('tagprovider')) {
    return [];
}

$userOptions = [
    'dynamicLoad' => true,
    'dynamicSearch' => true,
    'searchFields' => [
        ['name' => 'position', 'type' => 'string'],
        ['name' => 'email', 'type' => 'email'],
    ],
    // другие опции (itemOptions, tagOptions, badgeOptions)
];

return [
    'js' => 'dist/index.bundle.js',
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
                'options' => $userOptions,
            ],
        ]
    ],
];
```
Пример bundle.config.js:

```
// install/js/entity-selector/bundle.config.js
module.exports = {
    input: 'src/index.js',
    output: 'dist/index.bundle.js',
    concat: {
        css: ['src/style.css']
    },
    namespace: 'BX.TagSelector.EntitySelector',
    adjustConfigPhp: false
};
```

## Использование в JavaScript
Пример подключения и открытия диалога выбора с помощью BX.UI.EntitySelector.TagSelector:
```
<?php
// Пример страницы
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

use Bitrix\Main\Loader;
Loader::includeModule('tagprovider');

// Подключаем JS-расширение провайдера
\Bitrix\Main\UI\Extension::load('tagprovider.entity-selector');
?>

<input type="hidden" name="test1[]" value="0"/>
<button type="button" onclick="openSelector()">Выбрать пользователей</button>

<script>
let tagSelector = null;

function openSelector() {
    if (!tagSelector) {
        tagSelector = new BX.UI.EntitySelector.TagSelector({
            id: 'test1',
            multiple: true,
            dialogOptions: {
                entities: [
                    {
                        id: 'strcompany',
                        options: {
                            selectMode: 'usersAndDepartments', // режим: пользователи и отделы
                            fillDepartmentsTab: true,          // показывать вкладку «Отделы»
                            depthLevel: 3                       // глубина загрузки отделов
                        }
                    },
                ]
            }
        });
        tagSelector.renderTo(document.body);
    }
    
    tagSelector.getDialog().show();
}
</script>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
```