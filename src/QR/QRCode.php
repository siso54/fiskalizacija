<?php namespace Nticaric\Fiskalizacija\QR;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode as EQRCode;

class QRCode
{
    const QR_URL = 'https://porezna.gov.hr/rn';
    const DATE_TIME_FORMAT = 'Ymd_Hi';

    public $qrText;

    public function __construct($code, $dateTime, $totalValue) {
        if (!in_array(strlen($code), [32, 36])) {
            throw new \Exception('Code lenght must be either 32 or 36 chars');
        }
        \Carbon\Carbon::createFromFormat(self::DATE_TIME_FORMAT, $dateTime);
        $codeParamName = strlen($code) == 32 ? 'zki' : 'jir';
        $this->qrText = self::QR_URL . '?' . $codeParamName . '=' . $code .'&datv=' . $dateTime . '&izn=' .  number_format($totalValue, 2, ',', '');
    }

    public function getQRText() {
        return $this->qrText;
    }

    public function getBase64() {
        $qrCode = $this->getQR();
        return base64_encode($qrCode->writeString());
    }

    public function getBase64URI() {
        $qrCode = $this->getQR();
        return $qrCode->writeDataUri();;
    }

    private function getQR() {
        $qrCode = new EQRCode($this->qrText);
        $qrCode->setSize(200);
        $qrCode->setMargin(10);
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        return $qrCode;
    }
}
