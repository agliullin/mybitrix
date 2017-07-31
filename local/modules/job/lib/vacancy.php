<?php

namespace Job;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class VacancyTable extends Entity\DataManager
{
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

}