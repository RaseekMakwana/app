<?php

namespace app\models;

use Yii;
use TCPDF;
use yii\db\Query;

class CommonModel {

    public function getPdfObject() {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ajit Vaniya');
        $pdf->SetTitle('Demo Project PDF');
        $pdf->SetSubject('Demo Project PDF');
        $pdf->SetKeywords('Demo Project PDF');

        /*
          // set default header data
          $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

          // set header and footer fonts
          $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
          $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
         */

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        ///*
        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetMargins(5, 5, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        //*/
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('dejavusans', '', 10);

        // add a page
        $pdf->AddPage();

        return $pdf;
    }
}
