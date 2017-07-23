<?php 
/* Проверка, что миграция запускается через консоль */
$is_console = PHP_SAPI == 'cli' || (!isset($_SERVER['DOCUMENT_ROOT']) && !isset($_SERVER['REQUEST_URI']));
if ($is_console === false) {
	die();
}

/* Time limit */
@set_time_limit(0);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('CHK_EVENT', true);
define("NO_AGENT_CHECK", true);

/* Подключение prolog_before */
$_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . '/../../');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/* Подключение модуля */
CModule::IncludeModule("iblock");

/* Функция для вывода группы по коду */
function GetGroupByCode ($code) {
   $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $code));
   return $rsGroups->Fetch();
} 

/* Создание группы "Администраторы вакансий" */
$Group_Code = "vacancy_administrator";
if ($Group_Vacancy_Adm = GetGroupByCode($Group_Code) === false) : {
	$Group_Vacancy_Adm = new CGroup;
	$arFields = Array(
	  "ACTIVE"       => "Y",
	  "C_SORT"       => 10,
	  "NAME"         => "Администраторы вакансий",
	  "DESCRIPTION"  => "Администраторы вакансий",
	  "STRING_ID"      => $Group_Code
	  );
	$Group_Vacancy_Adm_ID = $Group_Vacancy_Adm->Add($arFields);
	if (strlen($Group_Vacancy_Adm->LAST_ERROR) > 0) {
		ShowError($Group_Vacancy_Adm->LAST_ERROR);
	}
} else: {
	$Group_Vacancy_Adm_ID = $Group_Vacancy_Adm["ID"];
} endif;

/* Создание/обновление типа ИБ "Работодатели" */
$arFields = Array(
	'ID'=>'employer',
	'SECTIONS'=>'Y',
	'IN_RSS'=>'N',
	'SORT'=>10,
	'LANG'=>Array(
		'ru'=>Array(
			'NAME'=>'Работодатели',
			'SECTION_NAME'=>'Разделы',
			'ELEMENT_NAME'=>'Работодатель'
		),
		'en'=>Array(
			'NAME'=>'Employers',
			'SECTION_NAME'=>'Sections',
			'ELEMENT_NAME'=>'Employer'
		)
	)
);
	
$obBlocktype = CIBlockType::GetByID('employer');

$obBlocktypeArray = $obBlocktype->Fetch();
if (count($obBlocktypeArray["arResult"]) == 0) {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Add($arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
} else {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Update('employer', $arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
}

/* Создание/обновление типа ИБ "Вакансии" */
$arFields = Array(
	'ID'=>'vacancy',
	'SECTIONS'=>'Y',
	'IN_RSS'=>'N',
	'SORT'=>10,
	'LANG'=>Array(
			'ru'=>Array(
				'NAME'=>'Вакансии',
				'SECTION_NAME'=>'Разделы',
				'ELEMENT_NAME'=>'Вакансия'
			),
			'en'=>Array(
				'NAME'=>'Vacancies',
				'SECTION_NAME'=>'Sections',
				'ELEMENT_NAME'=>'Vacancy'
			)
		)
    );
	
$obBlocktype = CIBlockType::GetByID('vacancy');
$obBlocktypeArray = $obBlocktype->Fetch();
if (count($obBlocktypeArray["arResult"]) == 0) {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Add($arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
} else {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Update('vacancy', $arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
}

/* Создание/обновление типа ИБ "Отклики" */
$arFields = Array(
	'ID'=>'response',
	'SECTIONS'=>'Y',
	'IN_RSS'=>'N',
	'SORT'=>10,
	'LANG'=>Array(
		'ru'=>Array(
			'NAME'=>'Отклики',
			'SECTION_NAME'=>'Разделы',
			'ELEMENT_NAME'=>'Отклик'
		),
		'en'=>Array(
			'NAME'=>'Responses',
			'SECTION_NAME'=>'Sections',
			'ELEMENT_NAME'=>'Response'
		)
	)
);
	
$obBlocktype = CIBlockType::GetByID('response');
$obBlocktypeArray = $obBlocktype->Fetch();
if (count($obBlocktypeArray["arResult"]) == 0) {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Add($arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
} else {
	$obBlocktype = new CIBlockType;
	$DB->StartTransaction();
	$res = $obBlocktype->Update('response', $arFields);
	if(!$res) {
		$DB->Rollback();
		echo $obBlocktype->LAST_ERROR.'<br>';
	} else {
		$DB->Commit();
	}
}


/* Создание/обновление ИБ "Работодатели" */
$ID = 0;
$arFields = Array(
	"ACTIVE" => "Y",
	"NAME" => "Работодатели",
	"CODE" => "employers",
	"IBLOCK_TYPE_ID" => "employer",
	"SITE_ID" => "s1",
	"SORT" => 10,
	"DESCRIPTION" => "Работодатели",
	"DESCRIPTION_TYPE" => "text",
	"GROUP_ID" => Array("1"=>"D", "2"=>"R", $Group_Vacancy_Adm_ID=>"W")
);

$ib = new CIBlock;
$ID = $ib->Add($arFields);
if($ID === false){
	echo $ib->LAST_ERROR.'<br>';
}

$ibp = new CIBlockProperty;

$arFields = Array(
	"NAME" => "Название",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "name",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Номер телефона",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "phone",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Почта",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "mail",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Адрес",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "address",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$EmployerIBID = $ID;

/* Создание/обновление ИБ "Вакансии" */
$ID = 0;
$arFields = Array(
	"ACTIVE" => "Y",
	"NAME" => "Вакансии",
	"CODE" => "vacancies",
	"IBLOCK_TYPE_ID" => "vacancy",
	"SITE_ID" => "s1",
	"SORT" => 10,
	"DESCRIPTION" => "Вакансии",
	"DESCRIPTION_TYPE" => "text",
	"GROUP_ID" => Array("1"=>"D", "2"=>"R", $Group_Vacancy_Adm_ID=>"W")
);

$ib = new CIBlock;
$ID = $ib->Add($arFields);
if($ID === false){
	echo 'Error: '.$ib->LAST_ERROR.'<br>';
}

$ibp = new CIBlockProperty;

$arFields = Array(
	"NAME" => "Название",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "name",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Специализация",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "spec",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Теги",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "tags",
	"PROPERTY_TYPE" => "L",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Работодатель",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "employer",
	"PROPERTY_TYPE" => "E",
	"USER_TYPE" => "EList", 
	"IBLOCK_ID" => $ID,
	"LINK_IBLOCK_ID" => $EmployerIBID
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Зарплата от",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "salary_from",
	"PROPERTY_TYPE" => "N",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Зарплата до",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "salary_up_to",
	"PROPERTY_TYPE" => "N",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Тестовое задание",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "task",
	"PROPERTY_TYPE" => "F",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$VacancyIBID = $ID;

/* Создание/обновление ИБ "Отклики" */
$ID = 0;
$arFields = Array(
	"ACTIVE" => "Y",
	"NAME" => "Отклики",
	"CODE" => "responses",
	"IBLOCK_TYPE_ID" => "response",
	"SITE_ID" => "s1",
	"SORT" => 10,
	"DESCRIPTION" => "Отклики",
	"DESCRIPTION_TYPE" => "text",
	"GROUP_ID" => Array("1"=>"D", "2"=>"R", $Group_Vacancy_Adm_ID=>"W")
);

$ID = $ib->Add($arFields);
if($ID === false){
	echo $ib->LAST_ERROR.'<br>';
}

$ibp = new CIBlockProperty;

$arFields = Array(
	"NAME" => "ID вакансии",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "id_vacancy",
	"PROPERTY_TYPE" => "S", 
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "ID пользователя",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "id_user",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "ID работодатель",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "id_employer",
	"PROPERTY_TYPE" => "S", 
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Сообщение",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "message",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Зарплата от",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "salary_from",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);

$arFields = Array(
	"NAME" => "Зарплата до",
	"ACTIVE" => "Y",
	"SORT" => "10",
	"CODE" => "salary_up_to",
	"PROPERTY_TYPE" => "S",
	"IBLOCK_ID" => $ID,
);
$PropID = $ibp->Add($arFields);



$ob = new CUserTypeEntity();
    $arFields = array(
    'ENTITY_ID' => 'USER',
    'FIELD_NAME' => 'UF_EMPLOYER',
    'USER_TYPE_ID' => 'string',
    'XML_ID' => '',
    'SORT' => 100,
    'MULTIPLE' => 'N',
    'MANDATORY' => 'N',
    'SHOW_FILTER' => 'I',
    'SHOW_IN_LIST' => 'Y',
    'EDIT_IN_LIST' => 'Y',
    'IS_SEARCHABLE' => 'N',
	'EDIT_FORM_LABEL'   => array(
        'ru'    => 'ID работодателя',
        'en'    => 'ID employer',
    ),
    'LIST_COLUMN_LABEL' => array(
        'ru'    => 'ID работодателя',
        'en'    => 'ID employer',
    ),
    'LIST_FILTER_LABEL' => array(
        'ru'    => 'ID работодателя',
		'en'    => 'ID employer',
	),
);
$FIELD_ID = $ob->Add($arFields);

?>