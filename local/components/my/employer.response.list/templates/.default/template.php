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
		<div class="well">
			<h4>Фильтрация</h4>
			<p>
			<form action="index.php" method="POST"> 
				<label for="f_user">Пользователь</label><br>
				<select name="f_user" class="f_user" />
					<option value=''>Выберите пользователя</option>
					<?	
					while($UserArray = $arResult["UArrayForFilter"]->GetNext()) {
					?>
					<option <?php if (isset($_POST["f_user"]) && $_POST["f_user"] == $UserArray["ID"]) echo "selected"; ?> value='<?=$UserArray["ID"];?>'><?=$UserArray['NAME']?> <?=$UserArray['LAST_NAME']?></option>
					<?
					}
					?>
				</select><br><br>
				<label for="f_vacancy">Вакансия</label><br>
				<select name="f_vacancy" class="f_vacancy" />
					<option value=''>Выберите вакансию</option>
					<?	
					while($VacancyArray = $arResult["VArrayForFilter"]->GetNext()) {
					?>
					<option <?php if (isset($_POST["f_vacancy"]) && $_POST["f_vacancy"] == $VacancyArray["ID"]) echo "selected"; ?> value='<?=$VacancyArray["ID"];?>'><?=$VacancyArray['NAME']?> <?=$VacancyArray['LAST_NAME']?></option>
					<?
					}
					?>
				</select><br><br>
				<label>Дата</label><br>
				<input type="date" value="<?=$_POST["f_date_start"]?>" name="f_date_start"> - <input type="date" value="<?=$_POST["f_date_end"]?>" name="f_date_end"><br><br>
				<button class="btn btn-primary" type="submit">Применить</button>
			</form>
			</p>
		</div>
		<?foreach($arResult["ITEMS"] as $arItem): { ?>
			<div class="response row">
				<p>
				<a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Отклик пользователя <?=$arItem["RESPONSE_USER"]["NAME"]?> <?=$arItem["RESPONSE_USER"]["LAST_NAME"]?> (<?=$arItem["RESPONSE_USER"]["LOGIN"]?>)</a><br>
				<b>Дата отклика</b>: <?=$arItem["DATE_CREATE"]?></br>
				<b>Пользователь</b>: <?=$arItem["RESPONSE_USER"]["NAME"]?> <?=$arItem["RESPONSE_USER"]["LAST_NAME"]?></br>
				<b>Вакансия</b>: <a href="../../vacancy/<?=$arItem["RESPONSE_VACANCY"]["ID"]?>/"><?=$arItem["RESPONSE_VACANCY"]["NAME"]?></a></br>
				<b>Желаемая зарплата</b>: <?=$arItem["PROPERTY_SALARY_FROM_VALUE"]?> - <?=$arItem["PROPERTY_SALARY_UP_TO_VALUE"]?>
				
				</p>
			</div>
		<?} endforeach;?>
		
		<?=$arResult["NAV_STRING"];?>
	</div>
</div>