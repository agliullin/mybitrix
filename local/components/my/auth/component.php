<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
global $USER;
if($USER->IsAuthorized()): {
	$arResult["NAME"] = $USER->GetParam("NAME");
	$arResult["LOGIN"] = $USER->GetParam("LOGIN");
	$arResult["AUTH"] = true;
	if (!empty($_POST)): {
		if (isset($_POST["LOG_OUT"])) { 
			$USER->Logout();
			LocalRedirect("index.php");
		}
	} endif;
} else: {
	$arResult["AUTH"] = false;
	$arResult["ERROR"] = null;
	$arRequestParams = array(
		"LOGIN",
		"PASSWORD"
	);
	$arParams["REGISTER_URL"] = ($arParams["REGISTER_URL"] <> ''? $arParams["REGISTER_URL"] : $currentUrl);
	$arResult["REGISTER_URL"] = ($custom_reg_page <> ''? $custom_reg_page : $arParams["REGISTER_URL"]);

	if (!empty($_POST)): {
		$paramSet = true;
		foreach ($arRequestParams as $param)
		{
			if (isset($_POST[$param])) {
				$arFields[$param] = htmlspecialcharsbx($_POST[$param]);
			} else {
				$paramSet = false;
			}
		}
		if ($paramSet): {
			$arAuthResult = $USER->Login($arFields["LOGIN"], $arFields["PASSWORD"]);
			if ($arAuthResult === true): {
				LocalRedirect("index.php");
			} else: {
				ShowMessage($arAuthResult);
			} endif;
		}  else: {
			$arResult["ERROR"] = "Ошибка авторизации.";
		} endif;
	} endif;
} endif;


$this->IncludeComponentTemplate();
