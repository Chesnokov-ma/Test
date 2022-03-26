<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Command\classes\ParseDataFromSite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Parsetable as ParseTable;    // сущность для ParseTable

class ParserCommand extends Command     // команда для запуска парсера и заполнения таблицы lovikupon.ParseTable базы данных
{
    private $entityManager;
    
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;
    }

    protected function configure()  // параметры комманды
    {
        $this->setName('app:parser')
        ->setDescription('Add(Update) database with parsed data from https://vladivostok.lovikupon.ru/today/')
        ->setHelp('This command parse https://vladivostok.lovikupon.ru/today/ and update database with collected data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)  // логика команды
    {
        $entityManager = $this->doctrine->getManager();

        // очищение таблицы и reset автоинкрементируемого поля id 
        $entityManager->getConnection()->prepare("TRUNCATE TABLE ParseTable;")->execute();
        
        $parser = new ParseDataFromSite();              // инициализация парсера
        $parsed_data = $parser->parseLovikupon();       // парсинг ловикупона

        for ($i = 0; $i < $parsed_data['count']; $i++)                       // выгрузка новых данных
        {
            $ptable = new ParseTable();
            
            $ptable->setTitle($parsed_data['title'][$i]);
            $ptable->setLink($parsed_data['link'][$i]);
            $ptable->setValiduntil($parsed_data['validuntil'][$i]);
            $ptable->setCountdown($parsed_data['countdown'][$i]);
            $ptable->setImg($parsed_data['img'][$i]);

            $entityManager->persist($ptable);
        }
        $entityManager->flush();

        echo "Downloaded " . $parsed_data['count'] . " rows\n";     // вывод сообщения с числом скачанных строк

        return 0;   // :execute()" must be of the type int, "null" returned
    }
}