<?
IncludeModuleLangFile(__FILE__);

class CIMYIELittleAdmin
{
	function OnPageStartHandler()
	{
		global $APPLICATION;
		
		$APPLICATION->SetAdditionalCSS("/bitrix/themes/.default/imyie.littleadmin.css");
	}
}
?>
