<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
$this->addExternalCss($this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');
?>


<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Вакансии</h3>
  </div>
  <div class="panel-body">
		
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="bx-newslist-container col-sm-6 col-md-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="bx-newslist-block">
					<div class="well">
						<div class="panel-heading">
							<h3 class="panel-title"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></h3>
						</div>
						<div class="panel-body">
					
						<?php $db_props = CIBlockElement::GetProperty($arItem["IBLOCK_ID"], $arItem['ID'], "sort", "asc", array());
						$PROPS = array();
						while($ar_props = $db_props->Fetch())
							$PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
						?>
						<p>Специализация: <?=$PROPS["spec"]?></p>
						<p>Зарплата: <?=$PROPS["salary_from"]?> - <?=$PROPS["salary_up_to"]?></p>
						<p>Работодатель: <?=$PROPS["employer"]?></p>
						</div>
						
					</div>
					
				</div>
				</div>
			<?endforeach;?>
  </div>
</div>
