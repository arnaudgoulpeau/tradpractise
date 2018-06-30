<?php

namespace AppBundle\Controller;

use AppBundle\Service\ExportPdfService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Classe controlleur pour gérer les exports.
 */
class ExportController extends Controller
{
    /**
     * @var ExportPdfService
     */
    private $exportPdfService;

    /**
     * ExportController constructor.
     * @param ExportPdfService $exportPdfService
     */
    public function __construct(ExportPdfService $exportPdfService)
    {
        $this->exportPdfService = $exportPdfService;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/export/pdf/tunes/{order}", name="export_pdf_tunes")
     */
    public function exportPdfTunesAction(Request $request, $order)
    {
        $mergedPath = $this->exportPdfService->exportTunesPdf($order);

        $response = new BinaryFileResponse($mergedPath);

        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, //use ResponseHeaderBag::DISPOSITION_ATTACHMENT to save as an attachement
            'Catalog.pdf'
        );

        return $response;
    }
}
