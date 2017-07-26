<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>


<?if($USER->IsAuthorized()) {?>

<p><?echo "Вы успешно зарегистрированы."?></p>

<? } else { ?>

<form class="form-horizontal" method="POST">
	<fieldset>
		<legend>Регистрация</legend>
		<div class="form-group">
			<label for="inputName" class="col-lg-2 control-label">Имя</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" name="NAME" placeholder="Имя" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputLastName" class="col-lg-2 control-label">Фамилия</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" name="LAST_NAME" placeholder="Имя" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputLogin" class="col-lg-2 control-label">Логин</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" name="LOGIN" placeholder="Логин" />
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label">Почта</label>
			<div class="col-lg-10">
				<input type="email" class="form-control" name="EMAIL" placeholder="Почта" />
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword" class="col-lg-2 control-label">Пароль</label>
			<div class="col-lg-10">
				<input type="password" class="form-control" name="PASSWORD" placeholder="Пароль">
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-10 col-lg-offset-2">
				<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
			</div>
		</div>
	</fieldset>
</form>

<? } ?>



