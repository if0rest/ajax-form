<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bootstrap 101 Template</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<style>.header {margin-bottom: 30px;}.tooltip-inner {white-space: pre;}</style>
</head>
<body>

	<div class="container">
		<div class="col-xs-10">
			<h1 class="header">Форма</h1>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputName" class="col-xs-2 control-label">Имя</label>
					<div class="col-xs-10">
						<input type="text" name="name" class="form-control" id="inputName" placeholder="Имя" value="Владимир" autocomplete>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail" class="col-xs-2 control-label">Email</label>
					<div class="col-xs-10">
						<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="post@mail.ru" autocomplete>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPhone" class="col-xs-2 control-label">Номер</label>
					<div class="col-xs-10">
						<input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="Номер" value="99999999999" autocomplete>
					</div>
				</div>
				<div class="form-group">
					<label for="inputFile" class="col-xs-2 control-label">Файл</label>
					<div class="col-xs-10">
						<input type="file" name="file" class="form-control-file" id="inputFile" multiple>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-10">
						<button type="submit" name="send" class="btn btn-success">Отправить</button>
					</div>
				</div>
			</form>

			<div id="result" class="col-xs-offset-2"></div>
		</div>
	</div>


	<script src="assets/js/jquery-1.12.4.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/ajax.js"></script>
  </body>
</html>