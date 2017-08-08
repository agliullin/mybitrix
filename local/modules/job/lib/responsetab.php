<?php


use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class ResponsetabTable extends Entity\DataManager
{
    public static function getTableName() {
        return "job_response";
    }
    
    public static function getMap() {
        return array(
            new Entity\IntegerField('id', array(
                'primary' => true,
                'autocomplete' => true,
            )),
            new Entity\IntegerField("id_vacancy", array(
                'required' => true,
            )),
            new Entity\IntegerField("id_user", array(
                'required' => true,
            )),
            new Entity\IntegerField("id_employer", array(
                'required' => true,
            )),
            new Entity\TextField('message', array(
                "required" => true,
            )),
            new Entity\IntegerField('salary_from', array(
                "required" => true,
            )),
            new Entity\IntegerField('salary_up_to', array(
                "required" => true,
            )),
        );
    }
}