<?php
@set_time_limit(0);
@ignore_user_abort(true);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('CHK_EVENT', true);
define("NO_AGENT_CHECK", true);

$_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . '/../../');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!\Bitrix\Main\Application::getConnection(ResponsetabTable::getConnectionName())->isTableExists(\Bitrix\Main\Entity\Base::getInstance('ResponsetabTable')->getDBTableName())) {
    \Bitrix\Main\Entity\Base::getInstance('ResponsetabTable')->createDbTable();
}
?>