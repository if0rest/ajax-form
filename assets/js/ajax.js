(function() {

	var app = {

		initialize : function () {
			this.modules();
			this.setUpListeners();
		},

		modules: function () {

		},

		setUpListeners: function () {
			$('form').on('submit', app.submitForm);
			$('form').on('keydown', 'input', app.removeError);
		},

		submitForm: function (e) {
			e.preventDefault();

			let $form = $(this),
				$submitBtn = $form.find('[type="submit"]');

			if (app.validateForm($form) === false)
				return false;

			$submitBtn.prop('disabled', true);

			if (window.FormData === undefined) {
				alert('Ваш браузер очень стар (как и Вы) и не поддерживает FormData :(');
			} else {
				/**
				 *  $form.serialize() выбирает только заполненные поля, игнорируя пустые (напр., неотмеченные чекбоксы).
				 *  FormData предоставляет полный список полей, всключая пустые, плюс работает с [type="file"].
				 */
				let formData = new FormData($form[0]),	// пакуем все текстовые поля
					$fileInput = $form.find('[type="file"]');

				if ($fileInput) {
					let inputName = $fileInput.attr('name');

					if ($fileInput.prop('multiple')) {
						$.each($fileInput.prop('files'), function(index, file) {
							formData.append(inputName+"[]", file);
						});
					} else {
						formData.append(inputName, $fileInput.prop('files')[0]);
						// formData.append('file', $fileInput[0].files[0]);
					}
				}

				$.ajax({
					context: $('#result'),	// равен $(this) внутри callback-функций
					type: "POST",
					url: "/upload.php",
					data: formData,
					dataType : 'json',   // xml, html, script, jsonp, text 	// если ответ сервера не соответствует типу, будет error
					processData: false,	 // не преобразовывать объект в соответствии с Content-type: application/x-www-form-urlencoded
					contentType: false,	 // будет ли jQuery устанавливать заголовок Content-type?
					cache: false,
					// success: function(data, textStatus, jqXHR){	 // вызовется, если серверный скрипт вернет 200 (проверять в Network)
					// 	console.log("success");
					// 	if (data.error == ''){
					// 		$(this).html(data.success);
					// 	} else {
					// 		$(this).html(data.error);
					// 	}
					// },
					success: function(data, textStatus, jqXHR){
						data.forEach(function(msg) {
							$("#result").append(msg);	// текущий this уже не #result, поэтому указываем явно
						});
						$form.wrapAll('<fieldset disabled></fieldset>').fadeTo("fast", .4);
					},
					error: function(jqXHR, textStatus, errorThrown){
						console.log("error:", errorThrown);
					},
					complete: function(jqXHR, textStatus){
						console.log("complete:",textStatus);
					},
					// statusCode: {     // альтернативная обработка ответа сервера
					// 	404: function() {
					// 		console.log("CODE 404 Page Not Found");
					// 	},
					// 	200: function() {
					// 		console.log("CODE 200 OK");
					// 	}
					// },
				});
			}
		},

		validateForm: function($form) {
			let $inputs = $form.find('input'),
				valid = true;

			$inputs.tooltip('destroy');

			$.each($inputs, function(index, node) {
				let
					$input = $(node),
					val = $input.val(),
					$formGroup = $input.parents('.form-group'),
					label = $formGroup.find('label').text().toLowerCase(),
					textError = 'Введите ' + label;

				if (!val.length) {
					$formGroup.addClass('has-error');

					$input.tooltip({
						trigger: 'manual',
						placement: 'right',
						title: textError
					}).tooltip('show');
					valid = false;
				} else {
					$formGroup.addClass('has-success').removeClass('has-error');
				}
			});
			return valid;
		},
		removeError: function() {
			$(this).tooltip('destroy').parent('.form-group').removeClass('has-error');
		}
	}

	app.initialize();

}());