<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Parsetable as ParseTable;    // сущность для ParseTable

class Controller extends AbstractController
{
    /**
     * @Route("/", name="app_")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $sort_by = $request->query->get("sort_by");
        if ($sort_by)
        {
            $parsed_data = $doctrine->getRepository(ParseTable::class)->findBy([], ["$sort_by" => 'asc']);  // если есть по чему сортировать
        }
        else
        {
            $parsed_data = $doctrine->getRepository(ParseTable::class)->findAll();  // неотсортированная таблица
        }


        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
            'parsed_data' => $parsed_data,
        ]);
    }
}
