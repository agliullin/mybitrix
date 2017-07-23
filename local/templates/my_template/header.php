<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE HTML>
<html>
<head>
<?$APPLICATION->ShowHead();?>
<meta name="viewport" content="width=device-width"/>
<title><?$APPLICATION->ShowTitle()?></title>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.min.css"/>
</head>
<body>
<?$APPLICATION->ShowPanel()?>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"edit_template", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "edit_template"
	),
	false
);?>
			