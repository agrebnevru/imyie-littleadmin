<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class imyie_littleadmin extends CModule
{
    public $MODULE_ID = "imyie.littleadmin";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage("IMYIE_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("IMYIE_INSTALL_DESCRIPTION");
        $this->PARTNER_NAME = GetMessage("IMYIE_INSTALL_COPMPANY_NAME");
        $this->PARTNER_URI = "https://agrebnev.ru/";
    }

    public function InstallDB()
    {
        ModuleManager::registerModule("imyie.littleadmin");

        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.littleadmin/install/copyfiles/themes",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes",
            true,
            true
        );
        return true;
    }

    public function InstallPublic()
    {
        return true;
    }

    public function InstallEvents()
    {
        RegisterModuleDependences(
            "main",
            "OnPageStart",
            "imyie.littleadmin",
            "CIMYIELittleAdmin",
            "OnPageStartHandler",
            "500"
        );

        return true;
    }

    public function CantInstall()
    {
        ModuleManager::unRegisterModule("imyie.littleadmin");

        return true;
    }

    public function UnInstallDB($arParams = array())
    {
        UnRegisterModule("imyie.littleadmin");

        return true;
    }

    public function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/themes/.default/imyie.littleadmin.css");

        return true;
    }

    public function UnInstallPublic()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        UnRegisterModuleDependences(
            "main",
            "OnPageStart",
            "imyie.littleadmin",
            "CIMYIELittleAdmin",
            "OnPageStartHandler",
            "500"
        );

        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION, $step;
        $keyGoodDB = $this->InstallDB();
        $keyGoodEvents = $this->InstallEvents();
        if ($keyGoodEvents) {
            $keyGoodFiles = $this->InstallFiles();
            $keyGoodPublic = $this->InstallPublic();
            $APPLICATION->IncludeAdminFile(
                GetMessage("SPER_INSTALL_TITLE"),
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.littleadmin/install/install.php"
            );
        } else {
            $this->CantInstall();
            $APPLICATION->IncludeAdminFile(
                GetMessage("SPER_INSTALL_TITLE"),
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.littleadmin/install/badinstall.php"
            );
        }
    }

    public function DoUninstall()
    {
        global $APPLICATION, $step;

        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();
        $this->UnInstallPublic();

        $APPLICATION->IncludeAdminFile(
            GetMessage("SPER_UNINSTALL_TITLE"),
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/imyie.littleadmin/install/uninstall.php"
        );
    }
}
