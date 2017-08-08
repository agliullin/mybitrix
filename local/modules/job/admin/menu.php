<?
IncludeModuleLangFile(__FILE__);

if ($APPLICATION->GetGroupRight("job")>"D") {
    $aMenu = array(
      "parent_menu" => "global_menu_content",
      "sort"        => 100,
      "url"         => "responses.php",
      "text"        => "Отклики",
      "title"       => "Отклики",
      "icon"        => "",
      "page_icon"   => "",
      "items_id"    => "job_response",
      "items"       => array(),
    );

    return $aMenu;
}
return false;
?>
