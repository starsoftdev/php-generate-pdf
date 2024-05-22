<?php

namespace PdfGen;

use Spiritix\Html2Pdf\Converter;
use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;

class PdfGenerate {
        public function generate($formData) {

            // print_r($formData);
            // exit;
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

        // $pdf = new TCPDF();
        // $pdf->AddPage();
        // $pdf->writeHTML($outputHtml, true, false, true, false, '');

        // $pdf->Output('hello_world.pdf');


        $input = new StringInput();
        $input->setHtml($outputHtml);

        $converter = new Converter($input, new DownloadOutput());

        // $converter->setOption('landscape', true);

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
        
        $output->download('google.pdf');

        
        echo "Hello World";
    }
}