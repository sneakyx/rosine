<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineDeliveriesPositions
 *
 * @ORM\Table(name="rosine_deliveries_positions")
 * @ORM\Entity
 */
class RosineDeliveriesPositions
{
    /**
     * @var int
     *
     * @ORM\Column(name="COMPANY_ID", type="integer", nullable=false, options={"default"="1"})
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

    /**
     * @return int
     */
    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    /**
     * @return int|null
     */
    public function getDeliveryId(): ?int
    {
        return $this->deliveryId;
    }

    /**
     * @return int|null
     */
    public function getPosiId(): ?int
    {
        return $this->posiId;
    }

    /**
     * @return string|null
     */
    public function getArtNumber(): ?string
    {
        return $this->artNumber;
    }

    /**
     * @param string $artNumber
     * @return $this
     */
    public function setArtNumber(string $artNumber): self
    {
        $this->artNumber = $artNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosiAmmount(): ?string
    {
        return $this->posiAmmount;
    }

    /**
     * @param string|null $posiAmmount
     * @return $this
     */
    public function setPosiAmmount(?string $posiAmmount): self
    {
        $this->posiAmmount = $posiAmmount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosiUnit(): ?string
    {
        return $this->posiUnit;
    }

    /**
     * @param string|null $posiUnit
     * @return $this
     */
    public function setPosiUnit(?string $posiUnit): self
    {
        $this->posiUnit = $posiUnit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosiPrice(): ?string
    {
        return $this->posiPrice;
    }

    /**
     * @param string|null $posiPrice
     * @return $this
     */
    public function setPosiPrice(?string $posiPrice): self
    {
        $this->posiPrice = $posiPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosiLocation(): ?int
    {
        return $this->posiLocation;
    }

    /**
     * @param int|null $posiLocation
     * @return $this
     */
    public function setPosiLocation(?int $posiLocation): self
    {
        $this->posiLocation = $posiLocation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosiSerial(): ?string
    {
        return $this->posiSerial;
    }

    /**
     * @param string|null $posiSerial
     * @return $this
     */
    public function setPosiSerial(?string $posiSerial): self
    {
        $this->posiSerial = $posiSerial;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosiText(): ?string
    {
        return $this->posiText;
    }

    /**
     * @param string|null $posiText
     * @return $this
     */
    public function setPosiText(?string $posiText): self
    {
        $this->posiText = $posiText;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosiTax(): ?int
    {
        return $this->posiTax;
    }

    /**
     * @param bool $posiTax
     * @return $this
     */
    public function setPosiTax(bool $posiTax): self
    {
        $this->posiTax = $posiTax;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDone(): ?bool
    {
        return $this->done;
    }

    /**
     * @param bool|null $done
     * @return $this
     */
    public function setDone(?bool $done): self
    {
        $this->done = $done;

        return $this;
    }
}
