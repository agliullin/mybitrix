<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) 
	die();

class VacancyList extends CBitrixComponent
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
		
		if (\Bitrix\Main\Loader::IncludeModule("job")) {
			$JobVacancy = new JobVacancy();
			$NavParams = $this->SetNavParams();
			$SelectParams = $this->SetSelectParams();
			$OrderParams = $this->SetOrderParams();
			$FilterParams = $this->SetFilterParams();
			$DetailPageUrl = $this->arParams["DETAIL_PAGE_URL"];
			$ListPageUrl = $this->arParams["LIST_PAGE_URL"];
			$Vacancies = $JobVacancy->GetVacancyList($OrderParams, $FilterParams, false, $NavParams, $SelectParams, $DetailPageUrl, $ListPageUrl);
			$this->arResult = $JobVacancy->GetVacanciesFields($Vacancies);
			$this->arResult["FOR_EMPLOYER"] = $this->arParams["FOR_EMPLOYER"];
			
			$JobEmployer = new JobEmployer();
			$EmployerListOrder = array('id' => 'asc');
			$EmployerListFilter = array(
				"IBLOCK_TYPE" => "employer",
				"IBLOCK_ID" => 2,
			);
			$EmployerListSelect = array(
				"ID",
				"NAME"
			);
			$this->arResult["EMPLOYER_LIST_FF"] = $JobEmployer->GetEmployerList($EmployerListOrder, $EmployerListFilter, false, false, $EmployerListSelect);
        }

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
			"PROPERTY_TAGS",
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
		
		if (!empty($this->arParams["F_EMPLOYER"]) && is_numeric($this->arParams["F_EMPLOYER"])) {
			$FilterParams = array_merge($FilterParams, array("PROPERTY_EMPLOYER" => $this->arParams["F_EMPLOYER"]));
		}
		if (!empty($this->arParams["F_SALARY_START"])) {
			$FilterParams = array_merge($FilterParams, array(">=PROPERTY_SALARY_UP_TO" => $this->arParams["F_SALARY_START"]));
		}
		if (!empty($this->arParams["F_SALARY_END"])) {
			$FilterParams = array_merge($FilterParams, array("<=PROPERTY_SALARY_FROM" => $this->arParams["F_SALARY_END"]));
		}
		if (!empty($this->arParams["F_ACTIVE"]) && ($this->arParams["F_ACTIVE"] == "Y" || $this->arParams["F_ACTIVE"] == "N")) {
			$FilterParams = array_merge($FilterParams, array("ACTIVE" => $this->arParams["F_ACTIVE"]));
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
		if (!empty($this->arParams["F_TAGS"])) {
			$tags = explode(", ", trim($this->arParams["F_TAGS"]));
			$strtags = "";
			foreach($tags as $tag) {
				$strtags .= $tag . " & ";
			}
			$strtags = substr($strtags , 0, -3);
			$FilterParams = array_merge($FilterParams, array("?PROPERTY_TAGS" => $strtags));
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
