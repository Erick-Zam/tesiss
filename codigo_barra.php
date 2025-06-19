<?php
require_once 'vendor/autoload.php';  // Si usas Composer para instalar la librería.

use Picqer\Barcode\BarcodeGeneratorPNG;

// Obtener los parámetros pasados en la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$lote = isset($_GET['lote']) ? $_GET['lote'] : '';
$fecha_cosecha = isset($_GET['fecha_cosecha']) ? $_GET['fecha_cosecha'] : '';

// Validar que los parámetros estén presentes
if (empty($id) || empty($lote) || empty($fecha_cosecha)) {
    echo "Faltan parámetros para generar el código de barras.";
    exit;
}

// Concatenar los valores para el código de barras
$codigo = $lote . "-" . $id . "-" . $fecha_cosecha;

// Establecer el encabezado adecuado para la imagen PNG
header('Content-Type: image/png');  // Indica que el contenido es una imagen PNG

// Crear el generador de código de barras
$generator = new BarcodeGeneratorPNG();

// Generar el código de barras
$codigo_barras = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

// Imprimir la imagen generada
echo $codigo_barras;
?>
