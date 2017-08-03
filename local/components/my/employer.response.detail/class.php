<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class ResponseDetail extends CBitrixComponent
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

		if (\Bitrix\Main\Loader::IncludeModule("job")) {
			$JobResponse = new JobResponse();
			$Item = $JobResponse->GetResponseById($this->arParams["ELEMENT_ID"]);
			
			$ResponseUser = CUser::GetByID($Item["PROPERTIES"]["id_user"]["VALUE"]);
			$ResponseUserArray = $ResponseUser->GetNext();
			$Item["RESPONSE_USER"] = $ResponseUserArray;
			
			$JobVacancy = new JobVacancy();
			$ResponseVacancyFilter = array("ID" => $Item["PROPERTIES"]["id_vacancy"]["VALUE"]);
			$ResponseVacancySelect = array("ID", "NAME");
			$Item["RESPONSE_VACANCY"] = $JobVacancy->GetVacancy(array(), $ResponseVacancyFilter, false, array(), $ResponseVacancySelect);

			$this->arResult["ITEM"] = $Item;
		}
		
		$this->IncludeComponentTemplate();
    
	}
	
}
