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
				Array(
					"COMPONENT_TEMPLATE" => ".default",
					"REGISTER_URL" => "reg.php"
				)
			);?> 
		</div>
		<div class="col-md-9">
			<?$APPLICATION->IncludeComponent(
				"my:employer.response", 
				".default", 
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"COMPONENT_TEMPLATE" => ".default",
					"IBLOCK_ID" => "22",
					"IBLOCK_TYPE" => "response",
					"RESPONSES_COUNT" => "10",
					"PROPERTY_CODE" => array(),
					"SEF_FOLDER" => "/employer/response/",
					"SEF_MODE" => "Y",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_BY2" => "NAME",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"SEF_URL_TEMPLATES" => array(
						"list" => "",
						"detail" => "#ELEMENT_ID#/",
					),
					"DETAIL_PAGE_URL" => "/employer/response/#ELEMENT_ID#/",
					"LIST_PAGE_URL" => "/employer/response/",
				),
				false
			);?>
		</div>
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>