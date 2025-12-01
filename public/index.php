<?php

require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;

// Directly output the QR code
$result = QrCodeBuilder::qrCodeBuilder();

header('Content-Type: ' . $result->getMimeType());
echo $result->getString();

// Save it to a file
$result->saveToFile(__DIR__ . '/qrcode.png');

// Generate a data URI to include image data inline (i.e. inside an <img> tag)
$dataUri = $result->getDataUri();
