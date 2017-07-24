<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$array = array(
	"id_user" => $USER->GetID(),
	"id_vacancy" => $arResult["ITEM"]["ID"],
	"id_employer" => $arResult["ITEM"]["PROPERTIES"]["employer"]["DETAIL"]["ID"]
);
?>
<script>
$(function() {
	
    $('#dialog').dialog({
        autoOpen: false,
		buttons: [
			{
				text: "Oтправить",
				click: function() {
					var $id_array = <?=json_encode($array)?>;
					var $form_array = {
						message: $('.message').val(),
						salary_from: $('.salary_from').val(),
						salary_up_to: $('.salary_up_to').val()
					};
					var $data = $.extend($id_array, $form_array);
					$.ajax({
						type: 'post',
						url: '/vacancy/add_response.php',
						data: $data,	
						success: function(result) {
							var tmp = JSON.parse(result);
							if (tmp.status) {
								if (tmp.status == 'success') {
									$(".info").removeClass("hide");
									$(".info").removeClass("error");
									$(".info").addClass("success");
									$(".info").html(tmp.info);
									$(".response").removeClass("btn-primary");
									$(".response").addClass("disabled");
									$(".response").addClass("btn-danger");
									$(".response").html("Вы уже откликнулись на вакансию");
									$('#add-response-form')[0].reset();
								} else {
									$(".info").removeClass("hide");
									$(".info").html(tmp.info);
								}
							}
							
						}
					});
					$('#dialog').dialog("close");
					
				}
			}
		],
		resizable: false,
		width: 500,
	});
	
	$('.response').button().click(function(e) {
        $('#dialog').dialog("open")
    });
	
	$('.ui-dialog-titlebar-close').button().click(function(e) {
		$('#dialog').dialog("close")
	});
			
});


</script>
<style>
#dialog textarea {
	width: 100%;
	resize: vertical;
}
.info {
	padding-bottom: 20px;
}
.error {
	color: red;
}
.success {
	color: green;
}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$arResult["ITEM"]["NAME"]?></h3>
	</div>
	<div class="panel-body">
		<div class="info hide"></div>
		<p>Начало активности: <?=$arResult["ITEM"]["DATE_CREATE"]?></p>
		<p><?=$arResult["ITEM"]["PROPERTIES"]["time_active"]["NAME"]?>: <?=$arResult["ITEM"]["PROPERTIES"]["time_active"]["VALUE"]?></p>
		<p>Зарплата: <?=$arResult["ITEM"]["PROPERTIES"]["salary_from"]["VALUE"]?> - <?=$arResult["ITEM"]["PROPERTIES"]["salary_up_to"]["VALUE"]?></p>
        <p><?=$arResult["ITEM"]["PROPERTIES"]["specialization"]["NAME"]?>: <?=$arResult["ITEM"]["PROPERTIES"]["specialization"]["VALUE"]?></p>
        <p><?=$arResult["ITEM"]["PROPERTIES"]["employer"]["NAME"]?>: <?=$arResult["ITEM"]["PROPERTIES"]["employer"]["DETAIL"]["NAME"]?></p>
		<p><?=$arResult["ITEM"]["PROPERTIES"]["task"]["NAME"]?>: <a href="../download.php?file=<?=$arResult["ITEM"]['PROPERTIES']['task']['VALUE']?>">Скачать</a></p>
		<?php if ($USER->IsAuthorized()) { 
			if ($arResult["ITEM"]["PROPERTIES"]["response"]) { ?>
			<p><button class="btn btn-danger btn-md disabled">Вы уже откликнулись на вакансию</button></p>
			<?php
			} else {		
		?>
			<p><button class="btn btn-primary btn-md response">Откликнуться на вакансию</button></p>
			<div id="dialog" title="Отклик">
				<form id="add-response-form" enctype="multipart/form-data">
					<p>
						<label>Сопроводительное письмо:</label>
						<textarea class="message" name="message" rows="5"></textarea>
					</p>
					<p>
						<label>Желаемая зарплата: </label><br>
						<input class="salary_from" type="number" size="6" name="salary_from" min="0" max="100000" value=""> - 
						<input class="salary_up_to" type="number" size="6" name="salary_up_to" min="0" max="100000" value="">
					</p>
				</form>
			</div>
		<?php 
			}
		} ?>
	</div>
</div>