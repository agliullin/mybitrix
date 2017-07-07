<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>

<div class="container">
	<div class="row">
	<?$APPLICATION->IncludeComponent(
		"my:register",
		"",
		Array(
			"AUTH" => "Y",
			"REQUIRED_FIELDS" => array("EMAIL","NAME"),
			"SET_TITLE" => "Y",
			"SHOW_FIELDS" => array("EMAIL","NAME"),
			"USE_BACKURL" => "Y"
		)
	);?>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>