# Тестовое Задание Lovikupon (Чесноков М.А.)

## Часть 1



```php
<?php
// оригинал
function makeMagicStringFromDate() { 
  $dateTime = new DateTime("now", new DateTimeZone("GMT")); 
  $str = $dateTime->format("YmdHis"); 
  for ($i = 0; $i < strlen($str); $i++) { 
    if (ctype_digit($str[$i])) {
      if ($str[$i] == 0) { 
        $str[$i] = 'a'; 
      }
      else { 
        $str[$i] = 10 - $str[$i]; 
      } 
    } 
  } 
  return $str; 
}

// мой вариант
function makeMagicStringFromDate_New() { 
  $dateTime = new DateTime("now", new DateTimeZone("GMT")); 
  $str = $dateTime->format("YmdHis");

  for ($i = 0; $i < strlen($str); $i++)
    if (ctype_digit($str[$i]))
      $str[$i] = $str[$i] == 0 ? 'a' : 10 - $str[$i];

  return $str;
}

echo "оригинал: " . makeMagicStringFromDate() . "</br>";
echo "мой вариант: " . makeMagicStringFromDate_New();
?>
```
Вывод:
```php
оригинал: 8a88a785a57156
мой вариант: 8a88a785a57156

```

## Часть 2
Запуск приложения:

0. Подразумевается, что все компоненты (composer, php, mysql) установлены
1. Распаковать проект и войти в него
```bash
cd ./Test
```
2. Настроить mysql (создать бд, пользователя, дать права):
```bash
sudo mysql
```
или
```bash
mysql -u root -p
```
В mysql
```sql
mysql> source sql_script.sql;
mysql> exit
```
3. Создать таблицу, запустить парсер и web-сервер (см. Прим.):
```bash
php bin/console doctrine:schema:create
php bin/console app:parser
php -S localhost:8000 -t public
```
4. Войти на локальный сайт:

`<Главная страница>` : <http://localhost:8000/>

`<Sonata>` : <http://localhost:8000/admin>

(таблица сортируется при нажатии на ссылки в названии столбцов)
## Примечание

По условию задания с сайта нужно взять «время и дата окончания» и «срок действия». Я посчитал, что это все относится к полю «Действует до», и взял данные в следующем формате (пример):

«Время и дата окончания»: «2022-05-15 00:00:00»

«Срок действия»: «51 дней 2 часов» (до окончания срока действия купона).

Картинки хранятся как ссылки.
