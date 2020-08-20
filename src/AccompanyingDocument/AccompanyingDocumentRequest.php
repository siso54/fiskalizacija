<?php namespace Nticaric\Fiskalizacija\AccompanyingDocument;

use Nticaric\Fiskalizacija\Request;

class AccompanyingDocumentRequest extends Request
{
    public function __construct(AccompanyingDocument $accompanyingDocument)
    {
        $this->request     = $accompanyingDocument;
        $this->requestName = 'PrateciDokumentiZahtjev';
    }
}