<?
$APPLICATION->IncludeComponent(
	"my:vacancy.list",
	".default",
	Array (
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"VACANCIES_COUNT" => $arParams["VACANCIES_COUNT"],	
        "DETAIL_PAGE_URL" => $arParams["DETAIL_PAGE_URL"],
        "LIST_PAGE_URL" => $arParams["LIST_PAGE_URL"],
		"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
		"SORT_BY1" => $arParams["SORT_BY1"],
		"SORT_BY2" => $arParams["SORT_BY2"],
		"SORT_ORDER1" => $arParams["SORT_ORDER1"],
		"SORT_ORDER2" => $arParams["SORT_ORDER2"],
    )
);
?>