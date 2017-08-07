<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if ($arResult["SHOW"] == "N") {
	LocalRedirect('/index.php') ;
}
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
	font-size: 18px;
}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Вакансии</h3>
	</div>
	<div class="panel-body">
	
		<?php
		if ($arResult["FOR_EMPLOYER"] == "Y") {
		?>
		<div class="well">
			<h4>Фильтрация</h4>
			<p>
			<form action="index.php" method="post"> 
				<label for="f_active">Активен</label><br>
				<select name="f_active" class="f_active" />
					<option value=''>Выберите активность</option>
					<option <?php if (isset($_POST["f_active"]) && $_POST["f_active"] == "Y") echo "selected"; ?> value='Y'>Активен</option>
					<option <?php if (isset($_POST["f_active"]) && $_POST["f_active"] == "N") echo "selected"; ?> value='N'>Не активен</option>
				</select><br><br>
				<label for="f_response">Наличие откликов</label><br>
				<select name="f_response" class="f_response" />
					<option value=''>Выберите наличие откликов</option>
					<option <?php if (isset($_POST["f_response"]) && $_POST["f_response"] == "Y") echo "selected"; ?> value='Y'>С откликами</option>
					<option <?php if (isset($_POST["f_response"]) && $_POST["f_response"] == "N") echo "selected"; ?> value='N'>Без откликов</option>
				</select><br><br>
				<label>Дата создания</label><br>
				<input type="date" value="<?=$_POST["f_date_start"]?>" name="f_date_start"> - <input type="date" value="<?=$_POST["f_date_end"]?>" name="f_date_end"><br><br>
				<button class="btn btn-primary" type="submit">Применить</button>
			</form>
			</p>
		</div>
		<?php 
		} elseif ($arResult["FOR_EMPLOYER"] == "N") {
			$cache = new CPHPCache();
			$cache_time = 86000;
			$cache_id = 'EMPLOYER_LIST_FF';
			$cache_path = '/EMPLOYER_LIST_FF/';
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
			{
			   	$res["EMPLOYER_LIST_FF"] = $cache->GetVars();
			   	if (is_array($res["EMPLOYER_LIST_FF"]) && (count($res["EMPLOYER_LIST_FF"]) > 0))
			      	$arRes["EMPLOYER_LIST_FF"] = $res["EMPLOYER_LIST_FF"];
			}
			if (is_array($arRes["EMPLOYER_LIST_FF"]))
			{
			   	$arResult["EMPLOYER_LIST_FF"] = $arRes["EMPLOYER_LIST_FF"];
			    if ($cache_time > 0)
			    {
		         	$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		         	$cache->EndDataCache(array("EMPLOYER_LIST_FF"=>$arResult["EMPLOYER_LIST_FF"]));
			    }
			}

			?>
			<div class="well">
				<h4>Фильтрация</h4>
				<p>
				<form action="index.php" method="post"> 
					<label for="f_employer">Работодатель</label><br>
					<select name="f_employer" class="f_employer" />
						<option value=''>Выберите работодателя</option>
						<?	
						while($EmployerArray = $arResult["EMPLOYER_LIST_FF"]->GetNext()) {
						?>
						<option <?php if (isset($_POST["f_employer"]) && $_POST["f_employer"] == $EmployerArray["ID"]) echo "selected"; ?> value='<?=$EmployerArray["ID"];?>'><?=$EmployerArray['NAME']?></option>
						<?
						}
						?>
					</select><br><br>
					<label>Желаемая зарплата</label><br>
					<input type="number" size="6" min="0" max="100000" value="<?=$_POST["f_salary_start"]?>" name="f_salary_start"> - <input type="number" size="6" min="0" max="100000" value="<?=$_POST["f_salary_end"]?>" name="f_salary_end"><br><br>
					<button class="btn btn-primary" type="submit">Применить</button>
				</form>
				</p>
			</div>
			<?php
		}
		?>
		<?php
		foreach($arResult["ITEMS"] as $arItem): { 
			if (empty($_POST["f_response"]) || ($_POST["f_response"] == "Y" && $arItem["RESPONSE_COUNT"] > 0) || ($_POST["f_response"] == "N" && $arItem["RESPONSE_COUNT"] == 0)) {
			?>
			<div class="vacancy well">
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
				<b>Дата создания</b>: <?=$arItem["DATE_CREATE"]?></br>
				<b>Работодатель</b>: <?=$arItem["EMPLOYER_INFO"]["NAME"]?></br>
				<b>Специализация</b>: <?=$arItem["PROPERTY_SPECIALIZATION_VALUE"]?></br>
				<b>Зарплата</b>: <?=$arItem["PROPERTY_SALARY_FROM_VALUE"]?> - <?=$arItem["PROPERTY_SALARY_UP_TO_VALUE"]?>
				</p>
			</div>
			<?
			}
		} endforeach;
		?>
		
		<?=$arResult["NAV_STRING"];?>
	</div>
</div>