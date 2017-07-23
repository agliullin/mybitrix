<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Вакансии</h3>
	</div>
	<div class="panel-body">
		<?foreach($arResult["ITEMS"] as $arItem): { ?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a><br>
			<p>
			Специализация: <?=$arItem["PROPERTY_SPECIALIZATION_VALUE"]?></br>
			Зарплата: <?=$arItem["PROPERTY_SALARY_FROM_VALUE"]?> - <?=$arItem["PROPERTY_SALARY_UP_TO_VALUE"]?>
			</p>
		<?} endforeach;?>
		
		<?=$arResult["NAV_STRING"];?>
	</div>
</div>