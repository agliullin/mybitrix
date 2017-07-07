<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="auth">
<?if($arResult["AUTH"] == false):?>
<h2>Авторизация</h2>
<?php if ($arResult["ERROR"] != null) {
	echo $arResult["ERROR"];
} ?>
<form method="POST">
	<input type="text" name="LOGIN" maxlength="50" size="17" placeholder="Логин"/>
	<input type="password" name="PASSWORD" maxlength="50" size="17" placeholder="Пароль"/>
	<input type="submit" name="LOG_IN" value="Войти" /><br />	
	<a href="<?=$arResult["REGISTER_URL"]?>">Регистрация</a>
</form>
<?
else:
?>
<h2>Профиль</h2>
<h5><?=$arResult["NAME"]?></h5>
<form method="POST">
	<h5>[<?=$arResult["LOGIN"]?>]</h5><br />
	<input type="submit" name="LOG_OUT" value="Выйти" />
</form>
<?endif?>
</div>
<style>
	input[type=submit] {
		padding:5px 15px; 
		background:#ccc; 
		border:0 none;
		cursor:pointer;
		-webkit-border-radius: 5px;
		border-radius: 5px; 
	}
	.auth {
		border: 1px solid black;
		padding: 10px;
		margin: 10px;
	}
</style>
