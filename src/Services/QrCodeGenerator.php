<?php

namespace App\Services;

use App\Entity\Logement;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;

class QrCodeGenerator
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    protected $entityManager;

    public function __construct(BuilderInterface $builder,EntityManagerInterface $entityManager)
    {
        $this->builder = $builder;
        $this->entityManager = $entityManager;
    }

    public function qrcode(Logement $logement)
    {
        $url = 'http://localhost:8000/hote/logement/';


        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');

        $path = dirname(__DIR__, 2) . '/public/assets/';

        // set qrcode
        $result = $this->builder
            ->data( $url .$logement->getId())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(400)
            ->margin(10)
            ->labelText($dateString)
            ->labelAlignment(new LabelAlignmentCenter())
            ->labelMargin(new Margin(15, 5, 5, 5))
            ->logoPath($path . 'img/logo.png')
            ->logoResizeToWidth('100')
            ->logoResizeToHeight('100')
            ->backgroundColor(new Color(221, 158, 3))
            ->build();

        //generate name
        $namePng = uniqid('', '') . '.png';

        //Save img png
        $result->saveToFile($path . 'qr-code/' . $namePng);

        $logement->setQrFileName( $namePng);


        return $result->getDataUri();
    }
}