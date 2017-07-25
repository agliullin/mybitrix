<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if ($arResult["SHOW"] == "N") {
	LocalRedirect('/index.php') ;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Отклик пользователя <?=$arResult["ITEM"]["RESPONSE_USER"]["NAME"]?> <?=$arResult["ITEM"]["RESPONSE_USER"]["LAST_NAME"]?> (<?=$arResult["ITEM"]["RESPONSE_USER"]["LOGIN"]?>)</h3>
	</div>
	<div class="panel-body">
		<p><b>Вакансия</b>: <a href="../../../vacancy/<?=$arResult["ITEM"]["RESPONSE_VACANCY"]["ID"]?>/"><?=$arResult["ITEM"]["RESPONSE_VACANCY"]["NAME"]?></a></p>
		<p><b>Имя</b>: <?=$arResult["ITEM"]["RESPONSE_USER"]["NAME"]?></p>
		<p><b>Фамилия</b>: <?=$arResult["ITEM"]["RESPONSE_USER"]["LAST_NAME"]?></p>
		<p><b>Почта</b>: <?=$arResult["ITEM"]["RESPONSE_USER"]["EMAIL"]?></p>
		<p><b>Желаемая зарплата</b>: <?=$arResult["ITEM"]["PROPERTIES"]["salary_from"]["VALUE"]?> - <?=$arResult["ITEM"]["PROPERTIES"]["salary_up_to"]["VALUE"]?></p>
        <p><b>Сопроводительное письмо</b>: <?=$arResult["ITEM"]["PROPERTIES"]["message"]["VALUE"]?></p>
		
	</div>
</div>