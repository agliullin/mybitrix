<? 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
global $USER;
if (!empty($_POST)) {
	$arRequestParams = array(
		"NAME",
		"EMAIL",
		"LOGIN",
		"PASSWORD"
	);
	$paramSet = true;
	foreach ($arRequestParams as $param)
	{
		if (isset($_POST[$param])) {
			$arFields[$param] = htmlspecialcharsbx($_POST[$param]);
		} else {
			$paramSet = false;
		}
	}
	if ($paramSet) {
		$user = new CUser;
		$id = $user->add($arFields);
		if (intval($id) > 0) {
			$arAuthResult = $USER->Login($arFields["LOGIN"], $arFields["PASSWORD"]);
		} else {
			echo $user->LAST_ERROR;
		}
	}
}
$this->IncludeComponentTemplate();
?>