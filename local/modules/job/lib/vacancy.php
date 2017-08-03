<?php

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class JobVacancy extends Entity\DataManager
{
    function __construct() {
        CModule::IncludeModule("iblock");
    }
    
    public static function getFilePath()
    {
      return __FILE__;
    }
   
    public static function getTableName()
    {
        return 'job_vacancy';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME', array(
                'required' => true,
            )),
            new Entity\StringField('SPECIALIZATION'),
            new Entity\IntegerField('SALARY_FROM'),
            new Entity\IntegerField('SALARY_UP_TO'),
            new Entity\DatetimeField('TIME_ACTIVE')
        );
    }

    public function GetVacancyById($Id) {
        $VacancyCIBlockElement = CIBlockElement::GetById($Id);
        $VacancyElement = $VacancyCIBlockElement->GetNextElement();
        $Result = $VacancyElement->GetFields();
        $Result["PROPERTIES"] = $VacancyElement->getProperties();
        return $Result;
    }

    public function GetVacancy($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams) {
        $VacancyCIBlockElement = CIBlockElement::GetList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams);
        $Vacancy = $VacancyCIBlockElement->GetNextElement();
        $VacancyFields = $Vacancy->GetFields();
        return $VacancyFields;
    }

    public function GetVacancyList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams, $DetailPageUrl, $ListPageUrl) {
        $Vacancies = CIBlockElement::GetList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams);
        $Vacancies->SetUrlTemplates($DetailPageUrl, "", $ListPageUrl);
        return $Vacancies;
    }

    public function GetVacanciesFields($Vacancies) {
        $Result = array();
        while ($Vacancy = $Vacancies->GetNextElement()) {
            $Item = $Vacancy->GetFields();
            $Item["RESPONSE_COUNT"] = $this->GetResponseCount($Item);
            $Item["EMPLOYER_INFO"] = $this->GetEmployerInfo($Item);
            $Result["ITEMS"][] = $Item;
            $Result["ELEMENTS"][] = $Item["ID"];
        }
        $Result["NAV_STRING"] = $Vacancies->GetPageNavStringEx(
            $navComponentObject,
            "",
            "",
            "Y"
        );
        return $Result;
    }

    public function GetResponseCount($Item) {
        $ResponseCountFilter = array("PROPERTY_ID_VACANCY" => $Item["ID"]);
        $ResponseCountSelect = array("PROPERTY_ID_VACANCY", "PROPERTY_ID_USER", "PROPERTY_ID_EMPLOYER");
        $ResponseCount = CIBlockElement::GetList(array(), $ResponseCountFilter, array(), false, $ResponseCountSelect);
        return $ResponseCount;
    }

    public function GetEmployerInfo($Item) {
        $EmployerOrder = array('id' => 'asc');
        $EmployerFilter = array(
            "IBLOCK_TYPE" => "employer",
            "IBLOCK_ID" => 2,
            "ID" => $Item["PROPERTY_EMPLOYER_VALUE"]
        );
        $EmployerSelect = array(
            "ID",
            "NAME"
        );
        $Employer = CIBlockElement::GetList($EmployerOrder, $EmployerFilter, false, false, $EmployerSelect);
        $EmployerInfo = $Employer->GetNext();
        return $EmployerInfo;
    }
}