/* Исходные условия */
CREATE TABLE `users` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) DEFAULT NULL,
`gender` INT(11) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
`birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
PRIMARY KEY (`id`)
);
CREATE TABLE `phone_numbers` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`user_id` INT(11) NOT NULL,
`phone` VARCHAR(255) DEFAULT NULL,
PRIMARY KEY (`id`)
);

/* Оптимизация БД */

/*
 Исправляю int на unsigned int, так как id не может быть < 0 (по крайней мере в условии об этом не сказано), поэтому я не
 вижу смысла в том, чтобы половина выделенной памяти просто не могла быть использована
 */
ALTER TABLE `users` MODIFY `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `phone_numbers` MODIFY `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `phone_numbers` MODIFY `user_id` INT(11) UNSIGNED NOT NULL;

/*
 Здесь так же нет смысла выделять так много памяти всего на 3 значения, поэтому меняю на TINYINT(1)
 */
ALTER TABLE `users` MODIFY `gender` TINYINT(1) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.';

/*
 Здесь я бы мог установить тип поля TIMESTAMP (так как в условии сказано что дата в unixtime), но в таком случае мы лишаемся
 возможности писать дату меньше 1970 года, а так как данное поле подразумевает дату рождения (а люди старше 1970 все еще есть)
 то я устанавливаю тип DATETIME
 Так же можно оставить тип INT(11), но DATETIME выглядит понятней для человека и с ним проще работать
 */
ALTER TABLE `users` MODIFY `birth_date`  DATETIME NOT NULL COMMENT 'Дата в unixtime.';

/* Так как будет происходить выборка с условием по этим полям, поставим составной индекс */
CREATE INDEX `user_gender_and_date` ON `users` (`gender`, `birth_date`);

/* Ставим внешний ключ phone_number.user_id -> users.id чтобы присваивать номер только существующему пользователю */
ALTER TABLE `phone_numbers` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/* Теперь пишем запрос на выборку */
SELECT users.name, COUNT(pn.user_id) AS phone_count FROM users
    LEFT JOIN phone_numbers pn on users.id = pn.user_id
    WHERE gender = 2
      AND birth_date
        BETWEEN DATE_SUB(NOW(), INTERVAL 22 YEAR) AND DATE_SUB(NOW(), INTERVAL 18 YEAR)
GROUP BY users.id;