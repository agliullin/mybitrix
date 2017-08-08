<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^../vacancy/#",
		"RULE" => "",
		"ID" => "my:vacancy",
		"PATH" => "/employer/index.php",
	),
	array(
		"CONDITION" => "#^/vacancy/#",
		"RULE" => "",
		"ID" => "my:vacancy",
		"PATH" => "/vacancy/index.php",
	),
	array(
		"CONDITION" => "#^/employer/response/#",
		"RULE" => "",
		"ID" => "my:employer.response",
		"PATH" => "/employer/response/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/admin/responses.php#",
		"RULE" => "",
		"PATH" => "/local/modules/job/admin/responses.php",
	),
);

?>