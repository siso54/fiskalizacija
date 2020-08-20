<?php namespace Nticaric\Fiskalizacija\AccompanyingDocument;

use XMLWriter;

class AccompanyingDocumentNumber
{
    public $numberNoteAccompanyingDocument;

    public $noteOfBusinessArea;

    public $noteOfExcangeDevice;

    public function __construct($numberNoteBill, $noteOfBusinessArea, $noteOfExcangeDevice)
    {
        $this->numberNoteBill = $numberNoteBill;
        $this->noteOfBusinessArea = $noteOfBusinessArea;
        $this->noteOfExcangeDevice = $noteOfExcangeDevice;
    }

    public function toXML()
    {
        $ns = 'tns';

        $writer = new XMLWriter();
        $writer->openMemory();

        $writer->setIndent(true);
        $writer->setIndentString("    ");
        $writer->startElementNs($ns, 'BrPratecegDokumenta', null);
        $writer->writeElementNs($ns, 'BrOznPD', null, $this->numberNoteBill);
        $writer->writeElementNs($ns, 'OznPosPr', null, $this->noteOfBusinessArea);
        $writer->writeElementNs($ns, 'OznNapUr', null, $this->noteOfExcangeDevice);
        $writer->endElement();

        return $writer->outputMemory();
    }
}
