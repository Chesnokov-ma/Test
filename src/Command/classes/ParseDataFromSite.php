<?php

namespace App\Command\classes;

require_once('simple_html_dom.php');

class ParseDataFromSite     // parser
{
    private $parsed_data = ['title' => [], 'link' => [], 'validuntil' => [], 'countdown' => [], 'img' => []];      // возвращаемые данные

    public function __consctructor()
    {
    }

    public function parseLovikupon()    // parse https://vladivostok.lovikupon.ru/today/
    {
        $this->html = file_get_html('https://vladivostok.lovikupon.ru/today/');     // получить html-сайта 

        // название и ссылка
        $promo_title = $this->html->find('.promo-title');   // получить соотвествующий div
        foreach (array_slice($promo_title, 1) as $a_tag)    // игнорировать первый баннер
        {
            $this->parsed_data['title'][] = "$a_tag->innertext";
            $this->parsed_data['link'][] = "https://vladivostok.lovikupon.ru$a_tag->href";  // необходимая информация
        }

        /* 
            На сайте есть поля [Дата и время до конца продаж] и [Действует до]
            Я посчитал, что под [Время и дата окончания] в задании правильнее считать именно начало суток окончания действия купона
            то есть, например, 2022-04-25 00:00:00
            В таком случае:
        */

        // время и дата окончания
        $valid_until = $this->html->find('.promo-info__valid-until');   
        foreach ($valid_until as $valid)
        {
            $valid_until_string = $valid->find('div')[0]->innertext . " 00:00:00";
            $this->parsed_data['validuntil'][] = date("Y-m-d H:i:s", strtotime($valid_until_string));

            $valid_until_time = new \DateTime($valid_until_string);     // срок действия расчитается как (дата и время окончания - дата и время сейчас) в часах
            $now_time = new \DateTime();

            $interval = $valid_until_time->diff($now_time);
            $this->parsed_data['countdown'][] = ($interval->days * 24) + $interval->h . "\n";
        }

        /* В случае [Дата и время до конца продаж]: */

        // $countdown = $this->html->find('.countdown');
        // foreach (array_slice($countdown, 1) as $count_element)
        //     $this->parsed_data['countdown'][] = $count_element->find('span[class=day]')[0]->innertext . " " . $count_element->find('span[class=min]')[0]->innertext;

        // картинка
        $promo_img = $this->html->find('.promo-image');     
        foreach (array_slice($promo_img, 1) as $img_tag)
            $this->parsed_data['img'][] = $img_tag->find('img')[0]->src;    // сохраняется полная ссылка на картинку

        $this->check_before_ret();    // проверка и расчет числа записей перед завершением
            
        return $this->parsed_data;
    }

    private function check_before_ret()     // если таблицы внезапно имеют разный размер 
    {
        $count = [];
        foreach($this->parsed_data as $table)
            $count[] = count($table);

        $min_count = min($count);   // находится самая маленькая таблица
            
        if (!(count(array_unique($count)) == 1))
        {
            foreach($this->parsed_data as $key => $value)                                       // размер всех остальный подстраивается под нее
                $this->parsed_data[$key] = array_slice($this->parsed_data[$key], $min_count);   // отбрасываются самые последнии записи
        }
            
        $this->parsed_data['count'] = $min_count;   // размер теперь одинаков для всех
    }
}