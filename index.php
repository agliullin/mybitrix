<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(" ");
?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<?$APPLICATION->IncludeComponent(
				"my:auth", 
				".default", 
				array(
					"REGISTER_URL" => "reg.php",
					"COMPONENT_TEMPLATE" => ".default"
				),
				false
			);?>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>