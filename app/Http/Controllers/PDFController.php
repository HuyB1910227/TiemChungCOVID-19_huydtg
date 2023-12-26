<?php
namespace App\Http\Controllers;


use Dompdf\Dompdf;
use Dompdf\Options;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pdf.vaccine-certificate')->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}