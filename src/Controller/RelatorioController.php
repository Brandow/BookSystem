<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Connection;

final class RelatorioController extends AbstractController
{
    public function gerarPdfLivros(Connection $connection): Response
    {
        
        $sql = "SELECT * FROM vw_relatorio_livros";
        $dados = $connection->fetchAllAssociative($sql);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Helvetica');
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('relatorio/livros.html.twig', [
            'dados_relatorio' => $dados,
            'dataGeracao' => new \DateTime(),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();


        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="relatorio_livros.pdf"',
        ]);
    }
}
