<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class VList extends CBitrixComponent
{
    public function executeComponent()
    {
		
		if ($this->arParams["FOR_EMPLOYER"] == "Y") {
			global $USER;
			$UserGroups = $USER->GetUserGroupArray();
			if (in_array(7, $UserGroups)) {
				$this->arResult["SHOW"] = "Y";
			} else {
				$this->arResult["SHOW"] = "N";
			}
		} elseif ($this->arParams["FOR_EMPLOYER"] == "N") {
			$this->arResult["SHOW"] = "Y";
		}
		
		CModule::IncludeModule("iblock");
		$NavParams = VList::SetNavParams();
		
		$SelectParams = VList::SetSelectParams();
		
		$OrderParams = VList::SetOrderParams();
		
		$FilterParams = VList::SetFilterParams();
		
		$Vacancies = CIBlockElement::GetList($OrderParams, $FilterParams, false, $NavParams, $SelectParams);
		$Vacancies->SetUrlTemplates($this->arParams["DETAIL_PAGE_URL"], "", $this->arParams["LIST_PAGE_URL"]);
		while($Vacancy = $Vacancies->GetNextElement()) {
			$Item = $Vacancy->GetFields();
			$ResponseFilterCount = array("PROPERTY_ID_VACANCY" => $Item["ID"]);
			$ResponseSelectCount = array("PROPERTY_ID_VACANCY", "PROPERTY_ID_USER", "PROPERTY_ID_EMPLOYER");
			$ResponseCount = CIBlockElement::GetList(array(),$ResponseFilterCount,array(),false,$ResponseSelectCount);
			$Item["RESPONSE_COUNT"] = $ResponseCount;
			$order = array('id' => 'asc');
			$EmployerFilter = array(
				"IBLOCK_TYPE" => "employer",
				"IBLOCK_ID" => 2,
				"ID" => $Item["PROPERTY_EMPLOYER_VALUE"]
			);
			$EmployerSelect = array(
				"ID",
				"NAME"
			);
			$EmployerArray = CIBlockElement::GetList($order, $EmployerFilter, false, false, $EmployerSelect);
			$Item["EMPLOYER_INFO"] = $EmployerArray->GetNext();
			
			$this->arResult["ITEMS"][] = $Item;
            $this->arResult["ELEMENTS"][] = $Item["ID"];
		}
		
		$this->arResult["FOR_EMPLOYER"] = $this->arParams["FOR_EMPLOYER"];
		// СПИСОК РАБОТОДАТЕЛЕЙ ДЛЯ ВЫПАДАЮЩЕГО СПИСКА
		$order = array('id' => 'asc');
		$EArrayFilter = array(
			"IBLOCK_TYPE" => "employer",
			"IBLOCK_ID" => 2,
		);
		$EArraySelect = array(
			"ID",
			"NAME"
		);
		$EArrayForFilter = CIBlockElement::GetList($order, $EArrayFilter, false, false, $EArraySelect);
		$this->arResult["EArrayForFilter"] = $EArrayForFilter;
		
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
			"ACTIVE",
			"DATE_CREATE",
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
		$FilterParams = array();
		
		if (isset($this->arParams["F_EMPLOYER"]) && is_numeric($this->arParams["F_EMPLOYER"])) {
			$FilterParams = array_merge($FilterParams, array("PROPERTY_EMPLOYER" => $this->arParams["F_EMPLOYER"]));
		}
		if (isset($this->arParams["F_SALARY_START"])) {
			$FilterParams = array_merge($FilterParams, array(">=PROPERTY_SALARY_UP_TO" => $this->arParams["F_SALARY_START"]));
		}
		if (isset($this->arParams["F_SALARY_END"])) {
			$FilterParams = array_merge($FilterParams, array("<=PROPERTY_SALARY_FROM" => $this->arParams["F_SALARY_END"]));
		}
		
		if (isset($this->arParams["F_ACTIVE"]) && ($this->arParams["F_ACTIVE"] == "Y" || $this->arParams["F_ACTIVE"] == "N")) {
			$FilterParams = array_merge($FilterParams, array("ACTIVE" => $this->arParams["F_ACTIVE"]));
		}
		if (isset($this->arParams["F_RESPONSE"]) && ($this->arParams["F_RESPONSE"] == "Y" || $this->arParams["F_RESPONSE"] == "N")) {
			$FilterParams = array_merge($FilterParams, array("ACTIVE" => $this->arParams["F_RESPONSE"]));
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
		
		if ($this->arParams["FOR_EMPLOYER"] == "Y") {
			global $USER;
			$arFilter = array("ID" => $USER->GetID());
			$arParams["SELECT"] = array("UF_EMPLOYER");
			$arRes = CUser::GetList($by,$order,$arFilter,$arParams);
			$arRes = $arRes->Fetch();
			$FilterParams = array_merge($FilterParams, array (
				"IBLOCK_TYPE" => $this->arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
				"PROPERTY_EMPLOYER" => $arRes["UF_EMPLOYER"]
			));
		} else {
			$FilterParams = array_merge($FilterParams, array (
				"IBLOCK_TYPE" => $this->arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
				"ACTIVE" => "Y",
			));
		}
		return $FilterParams;
	}
}
