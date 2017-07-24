<?php

class VAgent {
	public function Processing() {
        CModule::IncludeModule("iblock");
		$SelectParams = VAgent::SetSelectParams();
		$OrderParams = VAgent::SetOrderParams();
		$FilterParams = VAgent::SetFilterParams();
		$Vacancies = CIBlockElement::GetList($OrderParams, $FilterParams, false, false, $SelectParams);
		while ($Vacancy = $Vacancies->GetNextElement()) {
			$Item = $Vacancy->GetFields();
			log_array($Item);
			if (new DateTime($Item["PROPERTY_TIME_ACTIVE_VALUE"]) <= new DateTime()) {
				$Fields = array(
					"ACTIVE" => "N",
				);
				$UpdateVacancy = new CIBlockElement();
                $UpdateVacancyID = $Item["ID"];
                $UpdateVacancy->Update($UpdateVacancyID, $Fields);
			}
		}
	}
	
	public function SetSelectParams() {
		$SelectParams = array(
			"ID", 
			"IBLOCK_ID",
			"PROPERTY_TIME_ACTIVE",
			"ACTIVE"
		);
		return $SelectParams;
	}
	
	public function SetOrderParams() {
		$OrderParams = array(
			"ACTIVE_FROM" => "DESC",
			"NAME" => "ASC",
		);
		return $OrderParams;
	}
	
	public function SetFilterParams() {
		$FilterParams = array (
			"IBLOCK_ID" => 3,
			"ACTIVE" => "Y",
		);
		return $FilterParams;
	}
}
?>