<?php
if(!CModule::IncludeModule('iblock'))
	return false;

IncludeModuleLangFile(__FILE__);

CModule::AddAutoloadClasses(
	'job',
	array(
		'JobVacancy' => 'lib/vacancy.php',
		'JobEmployer'  => 'lib/employer.php',
	)
);
?>