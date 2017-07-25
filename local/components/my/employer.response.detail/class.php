<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class RDetail extends CBitrixComponent
{
    public function executeComponent()
    {
		global $USER;
		$UserGroups = $USER->GetUserGroupArray();
		if (in_array(7, $UserGroups)) {
			$this->arResult["SHOW"] = "Y";
		} else {
			$this->arResult["SHOW"] = "N";
		}
		CModule::IncludeModule("iblock");
		
		$ResponseCIBlockElement = CIBlockElement::GetById($this->arParams["ELEMENT_ID"]);
		$ResponseElement = $ResponseCIBlockElement->GetNextElement();
		$Item = $ResponseElement->GetFields();
		$Item["PROPERTIES"] = $ResponseElement->getProperties();
		
		$ResponseUser = CUser::GetByID($Item["PROPERTIES"]["id_user"]["VALUE"]);
		$ResponseUserArray = $ResponseUser->GetNext();
		$Item["RESPONSE_USER"] = $ResponseUserArray;
		
		
		$ResponseVacancyFilter = array("ID" => $Item["PROPERTIES"]["id_vacancy"]["VALUE"]);
		$ResponseVacancySelect = array("ID", "NAME");
		$ResponseVacancy = CIBlockElement::GetList(array(),$ResponseVacancyFilter,false,array(),$ResponseVacancySelect);
		$ResponseVacancyElement = $ResponseVacancy->GetNextElement();
		$ResponseVacancyArray = $ResponseVacancyElement->GetFields();
		$Item["RESPONSE_VACANCY"] = $ResponseVacancyArray;
		$FilterParams = RDetail::SetFilterParams();
		
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
