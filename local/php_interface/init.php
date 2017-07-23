<?php
session_start();
CModule::AddAutoloadClasses(
	'',
	array(
		'VAgent' => '/local/classes/agents/VAgent.php',
	)
);
?>