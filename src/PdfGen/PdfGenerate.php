<?php

namespace PdfGen;

use Spiritix\Html2Pdf\Converter;
use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;
use Spiritix\Html2Pdf\Output\FileOutput;

class PdfGenerate {
        public function generate($formData) {

        $outputDir = 'output';
        $outputFilePath = $outputDir . '/deploma_001.pdf';

        // Create the output directory if it doesn't exist
        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0777, true)) {
                die('Failed to create folders...');
            }
        }

        $doc = new \DOMDocument();
        $doc->loadHTMLFile(__DIR__. "/../files/estacio.html");
        
        for ($i = 0; $i < 5; $i ++) {
            $doc->getElementById("universidade".$i)->nodeValue = $formData['universidade'];
        }
        $doc->getElementById("curso")->nodeValue = $formData['curso'];
        $doc->getElementById("titulo")->nodeValue = $formData['titulo'];

        $nomeArr = explode(" ", $formData['nome']);

        $doc->getElementById("nome0")->nodeValue = $nomeArr[0]." ";

        if (count($nomeArr) > 2) {
            array_shift($nomeArr);
            $doc->getElementById("nome1")->nodeValue = implode(" ", $nomeArr);
        }
        
        $doc->getElementById("naturalidade")->nodeValue = $formData['naturalidade'];
        // $doc->getElementById("nacionalidade")->nodeValue = $formData['nacionalidade'];
        
        $doc->getElementById("data_nascimento")->nodeValue = date("d/m/Y", strtotime($formData['data_nascimento']));
        $doc->getElementById("identidade")->nodeValue = $formData['identidade'];

        $outputHtml = $doc->saveHTML();


        $input = new StringInput();
        $input->setHtml($outputHtml);

        $converter = new Converter($input, new FileOutput());


        $converter->setOptions([
            'printBackground' => true,
            'displayHeaderFooter' => true,
            'landscape' => true,
            // 'width' => '32.6898cm',
            // 'height' => '21.971cm',
            'preferCSSPageSize' => true,
            'margin' => array(
                'top' => '0',
                'bottom' => '0',
                'left' => '0',
                'right' => '0',
            )
        ]);

        $output = $converter->convert();
        
        $filePath = "output/deploma_001.pdf";
        try {
            $output->store($filePath);
        } catch(Exception $e) {
            echo "File is already existed";
        }


        if(!file_exists($filePath)){ // file does not exist
            die('file not found');
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=deploma_001.pdf");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // read the file from disk
            readfile($filePath);
        }

        // $converter1 = new Converter($input, new FileOutput());
        

        // $converter1->setOptions([
        //     'printBackground' => true,
        //     'displayHeaderFooter' => true,
        //     'landscape' => true,
        //     // 'width' => '32.6898cm',
        //     // 'height' => '21.971cm',
        //     'preferCSSPageSize' => true,
        //     'margin' => array(
        //         'top' => '0',
        //         'bottom' => '0',
        //         'left' => '0',
        //         'right' => '0',
        //     )
        // ]);

        // $output1 = $converter->convert();
        // $output1->download("deploma_001.pdf");
        
        echo "File is successfully created.";
    }
}