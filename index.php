<?php

require_once __DIR__ . '/vendor/autoload.php';

use PdfGen\FormInput;
use PdfGen\PdfGenerate;

$isGenPDF = count($_POST);

if ($isGenPDF == 0) {
    $entry = new FormInput();
    $entry->index();
} else {
    $entry = new PdfGenerate();
    $entry->generate($_POST);
}



// use PdfGen\PdfGenerate;

// $entry = new PdfGenerate();
// $entry->generate();

