<?php
declare(strict_types=1);

require_once 'Database.php';
require_once 'Users.php';

/*
 * Задачи которые стояли передо мной чтобы отрефакторить код
 * 1) Привести код в ООП
 * 2) Использовать подготовленные зарпосы (чтобы не допустить SQL-инъекций)
 * 3) Не использовать запросы в цикле (в данном случае можно исползовать WHERE IN)
 * 4) Ввести валидацию пришедших параметров (привести к одному типу, избваиться от дублирующих значений)
 * 5) Защита от XSS (вывод преобразовав спец символы в html сущности)
 */

$db = new Database('127.0.0.1', 'b2b', 'b2b', 'b2b_task');

$userIds = isset($_GET['user_ids']) ? (string)$_GET['user_ids'] : '6,7,3,21,5,7';

if (empty($userIds)) {
    throw new RuntimeException('User ids is empty');
}

$users = new Users($db, $userIds);

$usersData = $users->loadUsersData();

foreach ($usersData as $key => $row) {
    $id = $row['id'] ?? null;
    $name = $row['name'] ?? null;

    if (!empty($id) && !empty($name)) {
        $id = htmlspecialchars((string)$id);
        $name = htmlspecialchars($name);

        echo sprintf(
            "<a href='/show_user.php?id=%s'>%s</a>\n",
            $id,
            $name
        );
    }
}
