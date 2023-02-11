<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeliveryPosition
 *
 * @ORM\Table(name="rosine_deliveries_positions")
 * @ORM\Entity
 */
class DeliveryPosition
{
    /**
     * @var bool
     *
     * @ORM\Column(name="COMPANY_ID", type="boolean", nullable=false, options={"default"="1"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $companyId = true;

    /**
     * @var int
     *
     * @ORM\Column(name="DELIVERY_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $deliveryId;

    /**
     * @var int
     *
     * @ORM\Column(name="POSI_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $posiId;

    /**
     * @var string
     *
     * @ORM\Column(name="ART_NUMBER", type="string", length=40, nullable=false)
     */
    private $artNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSI_AMMOUNT", type="decimal", precision=9, scale=3, nullable=true)
     */
    private $posiAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSI_UNIT", type="string", length=20, nullable=true)
     */
    private $posiUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSI_PRICE", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $posiPrice;

    /**
     * @var int|null
     *
     * @ORM\Column(name="POSI_LOCATION", type="smallint", nullable=true)
     */
    private $posiLocation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSI_SERIAL", type="string", length=40, nullable=true)
     */
    private $posiSerial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSI_TEXT", type="string", length=1255, nullable=true)
     */
    private $posiText;

    /**
     * @var bool
     *
     * @ORM\Column(name="POSI_TAX", type="boolean", nullable=false)
     */
    private $posiTax;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="DONE", type="boolean", nullable=true)
     */
    private $done = '0';


}
