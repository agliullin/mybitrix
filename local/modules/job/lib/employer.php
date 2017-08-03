<?php

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class JobEmployer extends Entity\DataManager
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
        return 'job_employer';
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