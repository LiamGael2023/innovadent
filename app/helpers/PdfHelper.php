<?php
/**
 * PDF Helper - Generación de documentos PDF
 * Usa FPDF (librería simple sin dependencias)
 */

// Verificar si FPDF está disponible, si no, usar implementación básica
if (!class_exists('FPDF')) {
    /**
     * Implementación básica de PDF usando HTML + DomPDF concept
     * En producción, instalar FPDF: composer require setasign/fpdf
     */
    class SimplePDF {
        private $html = '';
        private $title = '';

        public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
            // Constructor compatible con FPDF
        }

        public function AddPage() {
            // Placeholder
        }

        public function SetFont($family, $style, $size) {
            // Placeholder
        }

        public function Cell($w, $h, $txt, $border = 0, $ln = 0, $align = '') {
            $this->html .= $txt . "\n";
        }

        public function Ln($h = null) {
            $this->html .= "<br>";
        }

        public function Output($dest = '', $name = '') {
            if ($dest === 'I') {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $name . '"');
                echo $this->generatePDF();
            } else if ($dest === 'D') {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $name . '"');
                echo $this->generatePDF();
            }
        }

        private function generatePDF() {
            // Generar HTML básico
            return "PDF Content: \n" . $this->html;
        }
    }
}

class PdfHelper {
    /**
     * Generar presupuesto en PDF
     */
    public static function generateQuotePDF($quote, $items, $patient, $clinic) {
        $pdf = self::createPDF();

        // Header
        self::addHeader($pdf, $clinic);

        // Título
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'PRESUPUESTO', 0, 1, 'C');
        $pdf->Ln(5);

        // Información del presupuesto
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 6, 'No. Presupuesto:', 0, 0);
        $pdf->Cell(0, 6, $quote['quote_number'], 0, 1);

        $pdf->Cell(50, 6, 'Fecha:', 0, 0);
        $pdf->Cell(0, 6, date('d/m/Y', strtotime($quote['quote_date'])), 0, 1);

        $pdf->Cell(50, 6, 'Válido hasta:', 0, 0);
        $pdf->Cell(0, 6, date('d/m/Y', strtotime($quote['valid_until'])), 0, 1);

        $pdf->Ln(5);

        // Información del paciente
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Paciente:', 0, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, $patient['first_name'] . ' ' . $patient['last_name'], 0, 1);
        $pdf->Cell(0, 6, 'Email: ' . ($patient['email'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 6, 'Teléfono: ' . ($patient['phone'] ?? 'N/A'), 0, 1);

        $pdf->Ln(10);

        // Tabla de tratamientos
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 8, 'Tratamiento', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Precio Unit.', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        foreach ($items as $item) {
            $pdf->Cell(80, 6, substr($item['treatment_name'], 0, 40), 1);
            $pdf->Cell(30, 6, $item['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 6, '$' . number_format($item['unit_price'], 2), 1, 0, 'R');
            $pdf->Cell(40, 6, '$' . number_format($item['subtotal'], 2), 1, 1, 'R');
        }

        $pdf->Ln(5);

        // Totales
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 6, 'Subtotal:', 0, 0, 'R');
        $pdf->Cell(40, 6, '$' . number_format($quote['subtotal'], 2), 0, 1, 'R');

        if ($quote['discount_amount'] > 0) {
            $pdf->Cell(150, 6, 'Descuento:', 0, 0, 'R');
            $pdf->Cell(40, 6, '-$' . number_format($quote['discount_amount'], 2), 0, 1, 'R');
        }

        if ($quote['tax_amount'] > 0) {
            $pdf->Cell(150, 6, 'IVA:', 0, 0, 'R');
            $pdf->Cell(40, 6, '$' . number_format($quote['tax_amount'], 2), 0, 1, 'R');
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 8, 'TOTAL:', 0, 0, 'R');
        $pdf->Cell(40, 8, '$' . number_format($quote['total'], 2), 0, 1, 'R');

        // Footer
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 5, 'Notas: ' . ($quote['notes'] ?? ''), 0, 1);

        // Output
        $filename = 'presupuesto_' . $quote['quote_number'] . '.pdf';
        $pdf->Output('I', $filename);
    }

    /**
     * Generar recibo de pago
     */
    public static function generateReceiptPDF($payment, $patient, $clinic) {
        $pdf = self::createPDF();

        self::addHeader($pdf, $clinic);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'RECIBO DE PAGO', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 6, 'No. Recibo:', 0, 0);
        $pdf->Cell(0, 6, $payment['payment_number'], 0, 1);

        $pdf->Cell(50, 6, 'Fecha:', 0, 0);
        $pdf->Cell(0, 6, date('d/m/Y', strtotime($payment['payment_date'])), 0, 1);

        $pdf->Ln(5);

        $pdf->Cell(50, 6, 'Recibimos de:', 0, 0);
        $pdf->Cell(0, 6, $patient['first_name'] . ' ' . $patient['last_name'], 0, 1);

        $pdf->Ln(5);

        $pdf->Cell(50, 6, 'La cantidad de:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, '$' . number_format($payment['amount'], 2) . ' ' . $payment['currency'], 0, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 6, 'Método de pago:', 0, 0);
        $pdf->Cell(0, 6, $payment['payment_method'], 0, 1);

        if ($payment['reference_number']) {
            $pdf->Cell(50, 6, 'Referencia:', 0, 0);
            $pdf->Cell(0, 6, $payment['reference_number'], 0, 1);
        }

        $filename = 'recibo_' . $payment['payment_number'] . '.pdf';
        $pdf->Output('I', $filename);
    }

    /**
     * Generar reporte de citas
     */
    public static function generateAppointmentsReportPDF($appointments, $startDate, $endDate, $clinic) {
        $pdf = self::createPDF('L'); // Landscape

        self::addHeader($pdf, $clinic);

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'REPORTE DE CITAS', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Período: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)), 0, 1, 'C');
        $pdf->Ln(10);

        // Tabla
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 8, 'Fecha', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Hora', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Paciente', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Doctor', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Tratamiento', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Estado', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        foreach ($appointments as $apt) {
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($apt['appointment_date'])), 1);
            $pdf->Cell(20, 6, date('H:i', strtotime($apt['start_time'])), 1);
            $pdf->Cell(60, 6, substr($apt['patient_name'], 0, 30), 1);
            $pdf->Cell(60, 6, substr($apt['doctor_name'], 0, 30), 1);
            $pdf->Cell(50, 6, substr($apt['treatment'] ?? 'N/A', 0, 25), 1);
            $pdf->Cell(30, 6, $apt['status'], 1, 1);
        }

        $filename = 'reporte_citas_' . date('Y-m-d') . '.pdf';
        $pdf->Output('D', $filename);
    }

    /**
     * Crear instancia de PDF
     */
    private static function createPDF($orientation = 'P') {
        if (class_exists('FPDF')) {
            return new FPDF($orientation, 'mm', 'A4');
        } else {
            return new SimplePDF($orientation, 'mm', 'A4');
        }
    }

    /**
     * Agregar header con logo
     */
    private static function addHeader($pdf, $clinic) {
        $pdf->AddPage();

        // Logo (si existe)
        if (!empty($clinic['logo_url']) && file_exists($clinic['logo_url'])) {
            $pdf->Image($clinic['logo_url'], 10, 10, 30);
        }

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $clinic['name'] ?? 'INNOVADENT', 0, 1, 'R');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, $clinic['address'] ?? '', 0, 1, 'R');
        $pdf->Cell(0, 5, 'Tel: ' . ($clinic['phone'] ?? ''), 0, 1, 'R');
        $pdf->Cell(0, 5, $clinic['email'] ?? '', 0, 1, 'R');

        $pdf->Ln(10);
    }
}
