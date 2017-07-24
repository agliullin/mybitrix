<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class VList extends CBitrixComponent
{
    public function executeComponent()
    {
		CModule::IncludeModule("iblock");
		$NavParams = VList::SetNavParams();
		
		$SelectParams = VList::SetSelectParams();
		
		$OrderParams = VList::SetOrderParams();
		
		$FilterParams = VList::SetFilterParams();
		
		$Responses = CIBlockElement::GetList($OrderParams, $FilterParams, false, $NavParams, $SelectParams);
		$Responses->SetUrlTemplates($this->arParams["DETAIL_PAGE_URL"], "", $this->arParams["LIST_PAGE_URL"]);
		
		while($Response = $Responses->GetNextElement()) {
			$Item = $Response->GetFields();
			$ResponseUser = CUser::GetByID($Item["PROPERTY_ID_USER_VALUE"]);
			$ResponseUserArray = $ResponseUser->GetNext();
			$Item["RESPONSE_USER"] = $ResponseUserArray;
			
			
			$ResponseVacancyFilter = array("ID" => $Item["PROPERTY_ID_VACANCY_VALUE"]);
			$ResponseVacancySelect = array("ID", "NAME");
			$ResponseVacancy = CIBlockElement::GetList(array(),$ResponseVacancyFilter,false,array(),$ResponseVacancySelect);
			$ResponseVacancyElement = $ResponseVacancy->GetNextElement();
			$ResponseVacancyArray = $ResponseVacancyElement->GetFields();
			$Item["RESPONSE_VACANCY"] = $ResponseVacancyArray;
			
			$this->arResult["ITEMS"][] = $Item;
            $this->arResult["ELEMENTS"][] = $Item["ID"];
			$this->arResult["FOR_EMPLOYER"] = $this->arParams["FOR_EMPLOYER"];
		}
		$this->arResult["NAV_STRING"] = $Responses->GetPageNavStringEx(
            $navComponentObject,
            "",
            "",
            "Y"
        );
		$this->IncludeComponentTemplate();
		
    }
	
	public function SetNavParams() {
		$NavParams = array(
			"nPageSize" => $this->arParams["RESPONSES_COUNT"],
		);
		return $NavParams;
	}
	
	public function SetSelectParams() {
		$SelectParams = array_merge($this->arParams["PROPERTY_CODE"], array(
			"ID", 
			"IBLOCK_ID",
			"NAME",
			"ACTIVE",
			"PROPERTY_ID_USER",
			"PROPERTY_ID_EMPLOYER",
			"PROPERTY_ID_VACANCY",
			"PROPERTY_MESSAGE",
			"PROPERTY_SALARY_FROM",
			"PROPERTY_SALARY_UP_TO"
		));
		return $SelectParams;
	}
	
	public function SetOrderParams() {
		$OrderParams = array(
			$this->arParams["SORT_BY1"] => $this->arParams["SORT_ORDER1"],
			$this->arParams["SORT_BY2"] => $this->arParams["SORT_ORDER2"],
		);
		return $OrderParams;
	}
	
	public function SetFilterParams() {
		global $USER;
		$arFilter = array("ID" => $USER->GetID());
		$arParams["SELECT"] = array("UF_EMPLOYER");
		$arRes = CUser::GetList($by,$order,$arFilter,$arParams);
		$arRes = $arRes->Fetch();
		$FilterParams = array (
			"IBLOCK_TYPE" => $this->arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
			"PROPERTY_ID_EMPLOYER" => $arRes["UF_EMPLOYER"]
		);
		return $FilterParams;
	}
}
