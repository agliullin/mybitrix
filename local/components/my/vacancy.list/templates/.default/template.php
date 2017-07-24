<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<style>
.active {
	color: green;
}
.disable {
	color: red;
}
.vacancy {
	margin-bottom: 20px;
	border-bottom: 1px solid gray;
	border-top: 1px solid gray;
	padding: 5px;
	
}
.vacancy a {
	font-size: 20px;
}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Вакансии</h3>
	</div>
	<div class="panel-body">
		<?foreach($arResult["ITEMS"] as $arItem): { ?>
			<div class="vacancy">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a><br>
				<p>
				<?php
				if ($arResult["FOR_EMPLOYER"] == "Y") {
					if ($arItem["ACTIVE"] == "Y") {
						echo '<div class="active">Активен</div>';
					} else {
						echo '<div class="disable">Не активен</div>';
					}
					echo '<div>Количество откликов: ' . $arItem["RESPONSE_COUNT"] .'</div>';
				}
				?>
				<b>Специализация</b>: <?=$arItem["PROPERTY_SPECIALIZATION_VALUE"]?></br>
				<b>Зарплата</b>: <?=$arItem["PROPERTY_SALARY_FROM_VALUE"]?> - <?=$arItem["PROPERTY_SALARY_UP_TO_VALUE"]?>
				</p>
			</div>
		<?} endforeach;?>
		
		<?=$arResult["NAV_STRING"];?>
	</div>
</div>