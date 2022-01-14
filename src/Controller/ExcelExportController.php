<?php

namespace App\Controller;

use App\Repository\EventRegistrationRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ExcelExportController extends AbstractController
{
    #[Route('/admin/export', name: 'excel_export')]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        $registrations = $eventRegistrationRepository->findAll();

        $spreadsheet = new Spreadsheet();

        setlocale(LC_TIME, "fr_BE");

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Liste des inscritpions");

        $sheet->setCellValue('A1', 'Date d\'inscription');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Nom');
        $sheet->setCellValue('D1', 'E-Mail');
        $sheet->setCellValue('E1', 'Téléphone');
        $sheet->setCellValue('F1', 'Adresse');
        $sheet->setCellValue('G1', 'Code Postal');
        $sheet->setCellValue('H1', 'Ville');
        $sheet->setCellValue('I1', 'Pays');
        $sheet->setCellValue('J1', 'Formation');
        $sheet->setCellValue('K1', 'Statut');

        $i = 2;
        foreach($registrations as $registration) {
            $sheet->setCellValue('A'.$i, $registration->getCreatedAt()->format('d-m-Y H:i:s'));
            $sheet->setCellValue('B'.$i, $registration->getFirstName());
            $sheet->setCellValue('C'.$i, $registration->getLastName());
            $sheet->setCellValue('D'.$i, $registration->getEmail());
            $sheet->setCellValue('E'.$i, $registration->getPhone());
            $sheet->setCellValue('F'.$i, $registration->getAddress());
            $sheet->setCellValue('G'.$i, $registration->getPostalCode());
            $sheet->setCellValue('H'.$i, $registration->getCity());
            $sheet->setCellValue('I'.$i, $registration->getCountry());
            $sheet->setCellValue('J'.$i, $registration->getEvent()->getWorkshop()->getTitle());
            $sheet->setCellValue('K'.$i, $registration->getStatus());

            $i++;
        }

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'liste_inscriptions_'.date("d_m_Y").'.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }
}
