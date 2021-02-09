<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineInvoicesPositions
 *
 * @ORM\Table(name="rosine_invoices_positions")
 * @ORM\Entity
 */
class RosineInvoicesPositions
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
     * @ORM\Column(name="INVOICE_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $invoiceId;

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

    public function getCompanyId(): ?bool
    {
        return $this->companyId;
    }

    public function getInvoiceId(): ?int
    {
        return $this->invoiceId;
    }

    public function getPosiId(): ?int
    {
        return $this->posiId;
    }

    public function getArtNumber(): ?string
    {
        return $this->artNumber;
    }

    public function setArtNumber(string $artNumber): self
    {
        $this->artNumber = $artNumber;

        return $this;
    }

    public function getPosiAmmount(): ?string
    {
        return $this->posiAmmount;
    }

    public function setPosiAmmount(?string $posiAmmount): self
    {
        $this->posiAmmount = $posiAmmount;

        return $this;
    }

    public function getPosiUnit(): ?string
    {
        return $this->posiUnit;
    }

    public function setPosiUnit(?string $posiUnit): self
    {
        $this->posiUnit = $posiUnit;

        return $this;
    }

    public function getPosiPrice(): ?string
    {
        return $this->posiPrice;
    }

    public function setPosiPrice(?string $posiPrice): self
    {
        $this->posiPrice = $posiPrice;

        return $this;
    }

    public function getPosiLocation(): ?int
    {
        return $this->posiLocation;
    }

    public function setPosiLocation(?int $posiLocation): self
    {
        $this->posiLocation = $posiLocation;

        return $this;
    }

    public function getPosiSerial(): ?string
    {
        return $this->posiSerial;
    }

    public function setPosiSerial(?string $posiSerial): self
    {
        $this->posiSerial = $posiSerial;

        return $this;
    }

    public function getPosiText(): ?string
    {
        return $this->posiText;
    }

    public function setPosiText(?string $posiText): self
    {
        $this->posiText = $posiText;

        return $this;
    }

    public function getPosiTax(): ?bool
    {
        return $this->posiTax;
    }

    public function setPosiTax(bool $posiTax): self
    {
        $this->posiTax = $posiTax;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(?bool $done): self
    {
        $this->done = $done;

        return $this;
    }


}
