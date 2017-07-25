<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class RList extends CBitrixComponent
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
		$NavParams = RList::SetNavParams();
		
		$SelectParams = RList::SetSelectParams();
		
		$OrderParams = RList::SetOrderParams();
		
		
		global $USER;
		$FilterParams = array("ID" => $USER->GetID());
		$SelectParams["SELECT"] = array("UF_EMPLOYER");
		$GetUser = CUser::GetList($by,$order,$FilterParams,$SelectParams);
		$GetUserArray = $GetUser->Fetch();
		$FilterParams = RList::SetFilterParams($GetUserArray["UF_EMPLOYER"]);
		
		$Responses = CIBlockElement::GetList($OrderParams, $FilterParams, false, $NavParams, $SelectParams);
		$Responses->SetUrlTemplates($this->arParams["DETAIL_PAGE_URL"], "", $this->arParams["LIST_PAGE_URL"]);
		
		while ($Response = $Responses->GetNextElement()) {
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
		}
		
		// СПИСОК ПОЛЬЗОВАТЕЛЕЙ ДЛЯ ВЫПАДАЮЩЕГО СПИСКА
		$order = array('id' => 'asc');
		$by = 'sort'; 
		$UArrayForFilter = CUser::GetList($order, $tmp);
		$this->arResult["UArrayForFilter"] = $UArrayForFilter;
		
		// СПИСОК ВАКАНСИЙ ДЛЯ ВЫПАДАЮЩЕГО СПИСКА
		$VArrayFilter = array(
			"PROPERTY_EMPLOYER" => $GetUserArray["UF_EMPLOYER"]
		);
		$VArraySelect = array(
			"ID",
			"NAME"
		);
		$VArrayForFilter = CIBlockElement::GetList($order, $VArrayFilter, false, false, $VArraySelect);
		$this->arResult["VArrayForFilter"] = $VArrayForFilter;
		
		
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
			"DATE_CREATE",
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
	
	public function SetFilterParams($UF_EMPLOYER) {
		$FilterParams = array (
			"IBLOCK_TYPE" => $this->arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
			"PROPERTY_ID_EMPLOYER" => $UF_EMPLOYER
		);
		
		if (isset($this->arParams["F_VACANCY"]) && is_numeric($this->arParams["F_VACANCY"])) {
			$FilterParams = array_merge($FilterParams, array("PROPERTY_ID_VACANCY" => $this->arParams["F_VACANCY"]));
		}
		if (isset($this->arParams["F_USER"]) && is_numeric($this->arParams["F_USER"])) {
			$FilterParams = array_merge($FilterParams, array("PROPERTY_ID_USER" => $this->arParams["F_USER"]));
		}
		if (!empty($this->arParams["F_DATE_START"])) {
			$date_start = new DateTime($this->arParams["F_DATE_START"]);
			$date_start = date('d.m.Y H:i:s', $date_start->getTimestamp());
			$FilterParams = array_merge($FilterParams, array(">=DATE_CREATE" => $date_start));
		}
		if (!empty($this->arParams["F_DATE_END"])) {
			$date_end = new DateTime($this->arParams["F_DATE_END"]);
			$date_end = date('d.m.Y H:i:s', $date_end->getTimestamp());
			$FilterParams = array_merge($FilterParams, array("<=DATE_CREATE" => $date_end));
		}
		
		return $FilterParams;
	}
}
