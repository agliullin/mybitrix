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
		
		$Vacancies = CIBlockElement::GetList($OrderParams, $FilterParams, false, $NavParams, $SelectParams);
		$Vacancies->SetUrlTemplates($this->arParams["DETAIL_PAGE_URL"], "", $this->arParams["LIST_PAGE_URL"]);
		while($Vacancy = $Vacancies->GetNextElement()) {
			$Item = $Vacancy->GetFields();
			$this->arResult["ITEMS"][] = $Item;
            $this->arResult["ELEMENTS"][] = $Item["ID"];
		}
		$this->arResult["NAV_STRING"] = $Vacancies->GetPageNavStringEx(
            $navComponentObject,
            "",
            "",
            "Y"
        );
		$this->IncludeComponentTemplate();
		
    }
	
	public function SetNavParams() {
		$NavParams = array(
			"nPageSize" => $this->arParams["VACANCIES_COUNT"],
		);
		return $NavParams;
	}
	
	public function SetSelectParams() {
		$SelectParams = array_merge($this->arParams["PROPERTY_CODE"], array(
			"ID", 
			"IBLOCK_ID",
			"NAME",
			"PROPERTY_TASK",
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
		$FilterParams = array (
			"IBLOCK_TYPE" => $this->arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
		);
		return $FilterParams;
	}
}
