# Quick Start
Кеширование производим через настройки php.ini для soap
docker/development/php/php.ini

1. docker-compose up -d
2. http://127.0.0.1:8082

## Configuring Xdebug settings for PhpStorm IDE

Для интеграции PHPStorm и Xdebug:
1. Создайте PHP interpreter в `Settings -> Languages & Frameworks -> PHP` для php-fpm в проекте;
2. Порт `9003` в меню `Settings -> Languages & Frameworks -> PHP -> Debug -> Xdebug -> Debug`.
3. Создайте сервер `Docker` в меню `Settings -> Languages & Frameworks -> PHP -> Servers`.
4. Настройте маппинг путей, если PHPStorm не сможет сам `Settings -> Languages & Frameworks -> PHP -> Path Mappings`,
5. Нажмите `Listen for PHP debug connections`;

Дополнительная информация [documentation](https://www.jetbrains.com/help/phpstorm/debugging-with-phpstorm-ultimate-guide.html).

### TESTING
  - выполнить тесты
      ```
      ЗАПУСТИТЬ ВСЕ ТЕСТЫ
      php ./vendor/bin/phpunit --debug --testdox 
  
      ЗАПУСТИТЬ UNIT
      php ./vendor/bin/phpunit --debug --testdox --testsuite unit
  
      ЗАПУСТИТЬ Functional
      php ./vendor/bin/phpunit --debug --testdox --testsuite functional
  
      ЗАПУСТИТЬ ВЫБОРОЧНЫЙ ТЕСТ
      php ./vendor/bin/phpunit --debug --testdox tests/Functional/Api/SomeTest.php
      ```