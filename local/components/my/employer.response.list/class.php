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
			
		if (\Bitrix\Main\Loader::IncludeModule("job")) {
			$JobResponse = new JobResponse();

			$UserFilterParams = array("ID" => $USER->GetID());
			$UserSelectParams["SELECT"] = array("UF_EMPLOYER");
			$GetUser = CUser::GetList($by, $order, $UserFilterParams, $UserSelectParams);
			$GetUserArray = $GetUser->Fetch();
			
			$FilterParams = $this->SetFilterParams($GetUserArray["UF_EMPLOYER"]);
			$NavParams = $this->SetNavParams();
			$SelectParams = $this->SetSelectParams();
			$OrderParams = $this->SetOrderParams();
			$DetailPageUrl = $this->arParams["DETAIL_PAGE_URL"];
			$ListPageUrl = $this->arParams["LIST_PAGE_URL"];

			$this->arResult = $JobResponse->GetResponseList($OrderParams, $FilterParams, false, $NavParams, $SelectParams, $DetailPageUrl, $ListPageUrl);
			
			$UserListOrder = array('id' => 'asc');
			$UserListBy = 'sort'; 
			$UserList = CUser::GetList($UserListOrder, $UserListBy);
			$this->arResult["USER_LIST_FF"] = $UserList;
			
			$JobVacancy = new JobVacancy();
			$VacancyListFilter = array(
				"PROPERTY_EMPLOYER" => $GetUserArray["UF_EMPLOYER"]
			);
			$VacancyListSelect = array(
				"ID",
				"NAME"
			);
			$VacancyList = $JobVacancy->GetVacancyList($order, $VacancyListFilter, false, false, $VacancyListSelect, false, false);
			$this->arResult["VACANCY_LIST_FF"] = $VacancyList;


		}
		
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
