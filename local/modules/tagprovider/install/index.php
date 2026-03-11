<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

class tagprovider extends CModule
{
    var $MODULE_ID = "tagprovider";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = "Y";

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . '/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage('CUSTOM_PROVIDER_INSTALL_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('CUSTOM_PROVIDER_INSTALL_MODULE_DESCRIPTION');
        
        // Рекомендуется заполнять PARTNER_NAME и URI
        $this->PARTNER_NAME = Loc::getMessage('CUSTOM_PROVIDER_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('CUSTOM_PROVIDER_PARTNER_URI');
    }

    // Вспомогательный метод для получения пути к модулю
    public function getPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        }
        return dirname(__DIR__);
    }

    function InstallDB()
    {
        // Регистрируем модуль в системе
        ModuleManager::registerModule($this->MODULE_ID);
        return true;
    }

    function UnInstallDB()
    {
        // Удаляем модуль из системы
        ModuleManager::unRegisterModule($this->MODULE_ID);
        return true;
    }

    function InstallFiles()
    {
        $path = $this->getPath() . "/install";

        // Копируем только JS и компоненты, если они есть
        if (is_dir($path . "/js")) {
            CopyDirFiles($path . "/js", $_SERVER["DOCUMENT_ROOT"] . "/local/js/".$this->MODULE_ID, true, true);
        }

        return true;
    }

    function UnInstallFiles()
    {
        if (!empty($this->MODULE_ID) && is_dir($_SERVER['DOCUMENT_ROOT']."/local/js/".$this->MODULE_ID)) {
            DeleteDirFilesEx("/local/js/".$this->MODULE_ID); // Путь лучше указывать от корня сайта без DOCUMENT_ROOT
        }
        return true;
    }


    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB();
    }

    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallFiles();
    }
}
