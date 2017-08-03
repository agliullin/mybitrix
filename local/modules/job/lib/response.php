<?php

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class JobResponse extends Entity\DataManager
{
    function __construct() {
        CModule::IncludeModule("iblock");
    }

    public function GetResponseById($Id) {
        $ResponseCIBlockElement = CIBlockElement::GetById($Id);
        $Response = $ResponseCIBlockElement->GetNextElement();
        $Result = $Response->GetFields();
        $Result["PROPERTIES"] = $Response->getProperties();
        return $Result;
    }

    public function GetResponseList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams, $DetailPageUrl, $ListPageUrl) {
        $Responses = CIBlockElement::GetList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams);
        $Responses->SetUrlTemplates($DetailPageUrl, "", $ListPageUrl);
        $ResponseList = $this->GetResponsesFields($Responses);
        return $ResponseList;
    }

    public function GetResponsesFields($Responses) {
        $Result = array();

        while ($Response = $Responses->GetNextElement()) {
            $Item = $Response->GetFields();
            $ResponseUserInfo = $this->GetUserInfo($Item);
            $Item["RESPONSE_USER"] = $ResponseUserInfo;
            
            $ResponseVacancy = new JobVacancy();
            $ResponseVacancyFilter = array("ID" => $Item["PROPERTY_ID_VACANCY_VALUE"]);
            $ResponseVacancySelect = array("ID", "NAME");
            $Item["RESPONSE_VACANCY"] = $ResponseVacancy->GetVacancy(array(), $ResponseVacancyFilter, false, array(), $ResponseVacancySelect);
            
            $Result["ITEMS"][] = $Item;
            $Result["ELEMENTS"][] = $Item["ID"];
        }

        $Result["NAV_STRING"] = $Responses->GetPageNavStringEx(
            $navComponentObject,
            "",
            "",
            "Y"
        );

        return $Result;
    }

    public function GetUserInfo($Item) {
        $GetUser = CUser::GetByID($Item["PROPERTY_ID_USER_VALUE"]);
        $UserInfo = $GetUser->GetNext();
        return $UserInfo;
    }
}