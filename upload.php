<?php

// Название <input type="file">
$input_name = 'file';

// Разрешенные расширения файлов в формате: "jpg","doc"...
$allow = [];

// Директория, куда будут загружаться файлы.
$upload_dir = __DIR__ . '/upload/';

if (!isset($_FILES[$input_name])) {
	$error = 'Файл не загружен.';
} else {
	// Преобразуем массив $_FILES в удобный вид для перебора в foreach.
	$files = [];
	$diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);

	if ($diff == 0) {
		$files = array($_FILES[$input_name]);
	} else {
		foreach($_FILES[$input_name] as $k => $l) {
			foreach($l as $i => $v) {
				$files[$i][$k] = $v;
			}
		}
	}

	foreach ($files as $file) {
		$error = $success = '';

		// Проверим на ошибки загрузки.
		if (!empty($file['error']) || empty($file['tmp_name'])) {
			$error = 'Ошибка при загрузке файла.';
		} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
			$error = 'Не удалось загрузить файл.';
		} else {
			// Оставляем в имени файла только буквы, цифры и некоторые символы.
			$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
			$name = mb_eregi_replace($pattern, '-', $file['name']);
			$name = mb_ereg_replace('[-]+', '-', $name);
			$ext  = strtolower(pathinfo($name)['extension']);

			if (empty($name) || empty($ext)) {
				$error = 'Недопустимые имя или тип файла';
			} elseif (!empty($allow) && !in_array($ext, $allow)) {
				$error = 'Недопустимый тип файла';
			} else {
				// Перемещаем файл в директорию.
				if (move_uploaded_file($file['tmp_name'], $upload_dir . $name)) {
					// Далее можно сохранить название файла в БД и т.п.
					$success = '<p style="color: green">Файл «' . $name . '» успешно загружен.</p>';
				} else {
					$error = 'Не удалось сохранить файл.';
				}
			}
		}

		// Формируем сообщения о статусе загрузке.
		if (!empty($success)) {
			$data[] = '<p style="color: green">' . $success . '</p>';
		}
		if (!empty($error)) {
			$data[] = '<p style="color: red">' . $error . '</p>';
		}
	}
}

// $data = array(
// 	'success' => $success,
// 	'error'   => $error,
// );

header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE);
exit();