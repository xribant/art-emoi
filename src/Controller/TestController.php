<?php

namespace App\Controller;

use App\Service\ExcelExport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(ExcelExport $export): Response
    {
        $export->exportToExcel('mon_export.xlsx', 'Test export Excel');


        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
