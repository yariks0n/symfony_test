Создаём миграцию
php bin/console doctrine:migrations:version --add --all
php bin/console make:migration

Мигрируем
php bin/console doctrine:migration:migrate

Загружаем тестовые данные
php bin/console doctrine:fixtures:load

Работа с очередями
php bin/console debug:messenger
 ------------------------------------------------------------------
  App\Message\TransactionNotification
      handled by App\MessageHandler\TransactionNotificationHandler
 ------------------------------------------------------------------

Запуск
  php bin/console messenger:consume async

 Для более подробного вывода
  php bin/console messenger:consume async -vv

Тесты
 php bin/phpunit