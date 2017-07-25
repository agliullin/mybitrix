<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if ($arResult["SHOW"] == "N") {
	LocalRedirect('/index.php') ;
}
?>
<style>
.response {
	margin: 5px;
}
.response .title {
	font-size: 18px;
}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Отклики</h3>
	</div>
	<div class="panel-body">
		<?foreach($arResult["ITEMS"] as $arItem): { ?>
			<div class="response row">
				<p>
				<a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Отклик пользователя <?=$arItem["RESPONSE_USER"]["NAME"]?> <?=$arItem["RESPONSE_USER"]["LAST_NAME"]?> (<?=$arItem["RESPONSE_USER"]["LOGIN"]?>)</a><br>
				<b>Пользователь</b>: <?=$arItem["RESPONSE_USER"]["NAME"]?> <?=$arItem["RESPONSE_USER"]["LAST_NAME"]?></br>
				<b>Вакансия</b>: <a href="../../vacancy/<?=$arItem["RESPONSE_VACANCY"]["ID"]?>/"><?=$arItem["RESPONSE_VACANCY"]["NAME"]?></a></br>
				<b>Желаемая зарплата</b>: <?=$arItem["PROPERTY_SALARY_FROM_VALUE"]?> - <?=$arItem["PROPERTY_SALARY_UP_TO_VALUE"]?>
				
				</p>
			</div>
		<?} endforeach;?>
		
		<?=$arResult["NAV_STRING"];?>
	</div>
</div>