<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

CModule::AddAutoloadClasses('job', array(
    'JobVacancy' => '/lib/vacancy.php',
    'JobEmployer' => '/lib/employer.php',
    'JobResponse' => '/lib/response.php',
    'ResponsetabTable' => '/lib/responsetab.php',
));

?>