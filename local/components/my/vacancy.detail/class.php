<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class VDetail extends CBitrixComponent
{
    public function executeComponent()
    {
		CModule::IncludeModule("iblock");
		
		$VacancyCIBlockElement = CIBlockElement::GetById($this->arParams["ELEMENT_ID"]);
		$VacancyElement = $VacancyCIBlockElement->GetNextElement();
		$Item = $VacancyElement->GetFields();
		$Item["PROPERTIES"] = $VacancyElement->getProperties();
		
		$EmployerCIBlockElement = CIBlockElement::GetById($Item["PROPERTIES"]["employer"]["VALUE"]);
		$EmployerElement = $EmployerCIBlockElement->GetNextElement();
		$Item["PROPERTIES"]["employer"]["DETAIL"] = $EmployerElement->GetFields();
		
		$FilterParams = VDetail::SetFilterParams();
		$ResponseCIBlockElement = CIBlockElement::GetList(Array(), $FilterParams, false, false, Array());
		if ($ResponseElement = $ResponseCIBlockElement->GetNextElement()) {
			$Item["PROPERTIES"]["response"] = true;
		} else {
			$Item["PROPERTIES"]["response"] = false;
		}
		
		$this->arResult["ITEM"] = $Item;
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
