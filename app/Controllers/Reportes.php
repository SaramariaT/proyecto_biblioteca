<?php

namespace App\Controllers;
use App\Models\LibroModel;
use App\Models\PrestamoModel;
use Dompdf\Dompdf;

class Reportes extends BaseController
{
    public function libros()
    {
        $libroModel = new LibroModel();
        $data['libros'] = $libroModel->findAll();

        return view('reportes/libros', $data);
    }

    public function libros_pdf()
    {
        $libroModel = new LibroModel();
        $data['libros'] = $libroModel->findAll();

        $html = view('reportes/libros_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("reporte_libros.pdf", ["Attachment" => true]);
    }

    public function prestamos_activos_pdf()
    {
        $prestamoModel = new PrestamoModel();
        $data['prestamos'] = $prestamoModel->obtenerPrestamosActivos(); // ✅ Método actualizado

        $html = view('reportes/prestamos_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("reporte_prestamos_activos.pdf", ["Attachment" => true]);
    }

    public function libros_estado_pdf()
    {
        $libroModel = new LibroModel();
        $data['libros'] = $libroModel->obtenerLibrosConEstadoYPrestamo();

        $html = view('reportes/libros_estado_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("reporte_libros_detallado.pdf", ["Attachment" => true]);
    }
}
