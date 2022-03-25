<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Command\classes\ParseDataFromSite;

class ParserCommand extends Command     // команда для запуска парсера и заполнения таблицы lovikupon.ParseTable базы данных
{
    protected function configure()  // параметры комманды
    {
        $this->setName('parser')
        ->setDescription('Add(Update) database with parsed data')
        ->setHelp('This command parse https://vladivostok.lovikupon.ru/today/ and update database with collected data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)  // логика команды
    {
        $parser = new ParseDataFromSite();              // инициализация парсера
        $parsed_data = $parser->parseLovikupon();       // парсинг ловикупона

        echo "Downloaded " . $parsed_data['count'] . " rows\n";     // вывод сообщения с числом скачанных строк

        $link = mysqli_connect("localhost", "user", "12345", "lovikupon");   // подклчение к БД
        mysqli_query($link, 'TRUNCATE TABLE ParseTable;');                   // очищение старой таблицы

        for ($i = 0; $i < $parsed_data['count']; $i++)                       // выгрузка новых данных
        {
            mysqli_query($link, 'INSERT INTO ParseTable (title, link, validuntil, countdown, img)
            VALUES (
            "' . $parsed_data['title'][$i] .'", 
            "' . $parsed_data['link'][$i] . '", 
            "' . $parsed_data['validuntil'][$i] . '", 
            "' . $parsed_data['countdown'][$i] . '", 
            "' . $parsed_data['img'][$i] . '");');

            // echo mysqli_error($link) . "\n";
        }

	    mysqli_close($link);    // закрыть соединение

        return 0;   // :execute()" must be of the type int, "null" returned
    }
}