<?php

namespace PdfGen;

class FormInput {
    public function index() {
        echo file_get_contents(__DIR__. '/../files/index.html');
    }
}