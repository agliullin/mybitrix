<?php 
/* Проверка, что миграция запускается через консоль */
$is_console = PHP_SAPI == 'cli' || (!isset($_SERVER['DOCUMENT_ROOT']) && !isset($_SERVER['REQUEST_URI']));
if ($is_console === false) {
	die();
}

/* Time limit */
@set_time_limit(0);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('CHK_EVENT', true);
define("NO_AGENT_CHECK", true);

/* Подключение prolog_before */
$_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . '/../../');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/* Подключение модуля */
CModule::IncludeModule("iblock");

CAgent::AddAgent(
    "VAgent::Processing();",
    "",
    "N",
    86400,
    "",
    "Y",
    "",
    10
);
?>