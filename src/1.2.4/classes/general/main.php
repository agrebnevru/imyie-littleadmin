<?php

IncludeModuleLangFile(__FILE__);

class CIMYIELittleAdmin
{
    public static function OnPageStartHandler()
    {
        global $APPLICATION;

        if (false === defined('ADMIN_SECTION') || false === ADMIN_SECTION) {
            return;
        }

        $APPLICATION->SetAdditionalCSS("/bitrix/themes/.default/imyie.littleadmin.css");
    }
}
