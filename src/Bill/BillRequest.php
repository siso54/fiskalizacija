<?php namespace Nticaric\Fiskalizacija\Bill;

use Nticaric\Fiskalizacija\Request;

class BillRequest extends Request
{
    public function __construct(Bill $bill)
    {
        $this->request = $bill;
        if ($bill->accompanyingDocumentSecurityCode) {
            $this->requestName = 'RacunPDZahtjev';
        }
        else {
            $this->requestName = 'RacunZahtjev';
        }
    }
}