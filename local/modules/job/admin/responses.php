<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");


$POST_RIGHT = $APPLICATION->GetGroupRight("job");
if ($POST_RIGHT == "D") {
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}
?>
<?
$TableID = "job_response";
$responseTable = new CAdminList($TableID, false);

function CheckFilter() {
    global $FilterArr, $responseTable;
    foreach ($FilterArr as $f) global $$f;
    /*
       здесь проверяем значения переменных $find_имя и, в случае возникновения ошибки,
       вызываем $lAdmin->AddFilterError("текст_ошибки").
    */
    return count($responseTable->arFilterErrors) == 0; // если ошибки есть, вернем false;
}

$FilterArr = Array(
    "f_id",
    "f_id_vacancy",
    "f_id_user",
    "f_id_employer",
);

$responseTable->InitFilter($FilterArr);
if (CheckFilter()) {
    $arFilter = Array(
        "id" => $f_id,
        "id_vacancy" => $f_id_vacancy,
        "id_user" => $f_id_user,
        "id_employer" => $f_id_employer
    );
}
$responseTable->AddHeaders(array(
        array(  
          "id" => "id",
          "content" => "ID",
          "sort" => "id",
          "default" => true,
        ),
        array(  
          "id" => "id_vacancy",
          "content" => "ID вакансии",
          "sort" => "id_vacancy",
          "default" => true,
        ),
        array(  
          "id" => "id_user",
          "content" => "ID пользователя",
          "sort" => "id_user",
          "default" => true,
        ),
        array(  
          "id" => "id_employer",
          "content" => "ID работодателя",
          "sort" => "id_employer",
          "default" => true,
        ),
        array(  
          "id" => "message",
          "content" => "Сопроводительное письмо",
          "sort" => "message",
          "default" => true,
        ),
        array(  
          "id" => "salary_from",
          "content" => "Зарплата от",
          "sort" => "salary_from",
          "default" => true,
        ),
        array(  
          "id" => "salary_up_to",
          "content" => "Зарплата до",
          "sort" => "salary_up_to",
          "default" => true,
        ),
    ));

    $rsData = ResponsetabTable::getList();
    $rsData = new CAdminResult($rsData, $TableID);
    $rsData->NavStart();
    $responseTable->NavText($rsData->GetNavPrint("страница"));
    while($arRes = $rsData->NavNext(true, "f_"))
        $responseTable->AddRow($f_ID, $arRes);
?>
<?
$APPLICATION->SetTitle("Отклики");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>

    <?$oFilter = new CAdminFilter(
    $TableID."_filter",
    array(
    "ID",
    "ID вакансии",
    "ID пользователя",
    "ID работодателя",
    )
    );
    ?>
    <form name="find_form" method="get" action="<?echo $APPLICATION->GetCurPage();?>">
        <?$oFilter->Begin();?>
        <tr>
            <td>ID</td>
            <td>
                <input type="text" name="f_id" size="10" value="<?=$_GET["f_id"]?>">
            </td>
        </tr>
        <tr>
            <td>ID вакансии</td>
            <td>
				<input type="text" name="f_id_vacancy" size="10" value="<?=$_GET["f_id_vacancy"]?>">
			</td>
        </tr>
        <tr>
            <td>ID пользователя</td>
            <td>
				<input type="text" name="f_id_user" size="10" value="<?=$_GET["f_id_user"]?>">
			</td>
        </tr>
        <tr>
            <td>ID работодателя</td>
            <td>
				<input type="text" name="f_id_employer" size="10" value="<?=$_GET["f_id_employer"]?>">
			</td>
        </tr>
        <?
        $oFilter->Buttons(array("table_id"=>$sTableID,"url"=>$APPLICATION->GetCurPage(),"form"=>"find_form"));
        $oFilter->End();
        ?>
    </form>

<?
$responseTable->DisplayList();
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>