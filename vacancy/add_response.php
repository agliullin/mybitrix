<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>

<?
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	if (!empty($_REQUEST['message']) and !empty($_REQUEST['salary_from']) and !empty($_REQUEST['salary_up_to']) and !empty($_REQUEST['id_vacancy']) and !empty($_REQUEST['id_user']) and !empty($_REQUEST['id_employer'])){
		
		CModule::IncludeModule('iblock'); 
		
		$el = new CIBlockElement;

		$PROPERTIES = array();
		$PROPERTIES['message'] = $_POST['message'];
		$PROPERTIES['salary_from'] = $_POST['salary_from'];
		$PROPERTIES['salary_up_to'] = $_POST['salary_up_to'];
		$PROPERTIES['id_vacancy'] = $_POST['id_vacancy'];
		$PROPERTIES['id_employer'] = $_POST['id_employer'];
		$PROPERTIES['id_user'] = $_POST['id_user'];

		$iblock_id = 22;
		$section_id = false;
		
		$arFields = Array(
			"NAME" => "Отклик пользователя с ID " . $_POST['id_user'] . " на вакансию с ID " . $_POST['id_vacancy'],
			"IBLOCK_ID"      => $iblock_id,
			"PROPERTY_VALUES"=> $PROPERTIES,
			"ACTIVE"         => "Y", 
		);

		if($ID = $el->Add($arFields)) {
			$result = '{"status":"success","info":"Отклик успешно добавлен"}';
		} else {
			$result = '{"status":"error","info":"' . $el->LAST_ERROR . '"}';
		}
		
	} else {
		$result = '{"status":"error","info":"Все поля обязательны для заполнения"}';
	}
	
	echo $result;
}
?>