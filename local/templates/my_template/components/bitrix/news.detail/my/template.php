<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
$this->addExternalCss($this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');
CUtil::InitJSCore(array('fx'));
?>
<?php 
	$db_props = CIBlockElement::GetProperty(13, $arParams["ELEMENT_ID"], "sort", "asc", array());
	$PROPS = array();
	while($ar_props = $db_props->Fetch())
		$PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
	?>
<div class="well">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$PROPS["name"]?></h3>
	</div>
	<div class="panel-body">

			
	<p>Специализация: <?=$PROPS["spec"]?></p>
	<p>Зарплата: <?=$PROPS["salary_from"]?> - <?=$PROPS["salary_up_to"]?></p>
	<p>Работодатель: <?=$PROPS["employer"]?></p>
	</div>
</div>