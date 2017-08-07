<?php

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class JobEmployer extends Entity\DataManager
{
    function __construct() {
        CModule::IncludeModule("iblock");
    }
    
    public function GetEmployerById($Id) {
        $EmployerCIBlockElement = CIBlockElement::GetById($Id);
        $EmployerElement = $EmployerCIBlockElement->GetNextElement();
        $Result = $EmployerElement->GetFields();
        return $Result;
    }

    public function GetEmployerList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams) {
        $EmployerList = CIBlockElement::GetList($OrderParams, $FilterParams, $GroupByParams, $NavParams, $SelectParams);
        return $EmployerList;
    }
}