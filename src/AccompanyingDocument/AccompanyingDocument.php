<?php

namespace Nticaric\Fiskalizacija\AccompanyingDocument;

use XMLWriter;

class AccompanyingDocument
{

    public $oib;

    public $dateTime;

    public $accompanyingDocumentNumber;

    public $totalValue;

    public $noteOfRedlivery = false;


    public function setOib($oib)
    {
        $this->oib = $oib;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function setAccompanyingDocumentNumber($accompanyingDocumentNumber)
    {
        $this->accompanyingDocumentNumber = $accompanyingDocumentNumber;
    }

    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;
    }

    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
    }

    public function setNoteOfRedlivery($noteOfRedlivery)
    {
        $this->noteOfRedlivery = $noteOfRedlivery;
    }


    /**
     * Generiranje zaštitnog koda na temelju ulaznih parametara
     * @param  [type] $pkey privatni kljuc iz certifikata
     * @param  [type] $oib  oib
     * @param  [type] $dt   datum i vrijeme izdavanja računa zapisan kao tekst u formatu 'dd.mm.gggg hh:mm:ss'
     * @param  [type] $bor  brojčana oznaka računa
     * @param  [type] $opp  oznaka poslovnog prostora
     * @param  [type] $onu  oznaka naplatnog uređaja
     * @param  [type] $uir  ukupni iznos računa
     * @return [type]       md5 hash
     */
    public function securityCode($pkey, $oib, $dt, $bor, $opp, $onu, $uir)
    {
        $medjurezultat = "";
        $medjurezultat .= $oib;
        $medjurezultat .= $dt;
        $medjurezultat .= $opp;
        $medjurezultat .= $bor;
        $medjurezultat .= $onu;
        $medjurezultat .= $uir;

        $zastKodSignature = null;

        if (!openssl_sign($medjurezultat, $zastKodSignature, $pkey, OPENSSL_ALGO_SHA1)) {
            throw new \Exception('Error creating security code');
        }

        return $this->securityCode = md5($zastKodSignature);
    }

    public function toXML()
    {
        $ns = 'tns';

        $writer = new XMLWriter();
        $writer->openMemory();

        $writer->setIndent(true);
        $writer->setIndentString("    ");
        $writer->startElementNs($ns, 'PrateciDokument', null);
        $writer->writeElementNs($ns, 'Oib', null, $this->oib);
        $writer->writeElementNs($ns, 'DatVrijeme', null, $this->dateTime);

        $writer->writeRaw($this->accompanyingDocumentNumber->toXML());

        $writer->writeElementNs($ns, 'IznosUkupno', null, number_format($this->totalValue, 2, '.', ''));
        $writer->writeElementNs($ns, 'ZastKodPD', null, $this->securityCode);
        $writer->writeElementNs($ns, 'NakDost', null, $this->noteOfRedlivery ? "true" : "false");

        $writer->endElement();

        return $writer->outputMemory();
    }
}
