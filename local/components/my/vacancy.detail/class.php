<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class VacancyDetail extends CBitrixComponent
{
    public function executeComponent()
    {
		
		if (\Bitrix\Main\Loader::IncludeModule("job")) {
			$JobVacancy = new JobVacancy();
			$Item = $JobVacancy->GetVacancyById($this->arParams["ELEMENT_ID"]);
			
			$JobEmployer = new JobEmployer();
			$Item["PROPERTIES"]["employer"]["DETAIL"] = $JobEmployer->GetEmployerById($Item["PROPERTIES"]["employer"]["VALUE"]);
			
			$FilterParams = $this->SetFilterParams();
			$ResponseCIBlockElement = CIBlockElement::GetList(Array(), $FilterParams, false, false, Array());
			if ($ResponseElement = $ResponseCIBlockElement->GetNextElement()) {
				$Item["PROPERTIES"]["response"] = true;
			} else {
				$Item["PROPERTIES"]["response"] = false;
			}
			
			$this->arResult["ITEM"] = $Item;
		}
		$this->IncludeComponentTemplate();
    
	}
	
	public function SetFilterParams() {
		$FilterParams = array (
			"IBLOCK_TYPE" => "response",
			"IBLOCK_ID" => "22",
			"ACTIVE" => "Y",
			"PROPERTY_ID_USER" => $GLOBALS['USER']->GetID(),
			"PROPERTY_ID_VACANCY" => $this->arParams["ELEMENT_ID"]
		);
		return $FilterParams;
	}
}
