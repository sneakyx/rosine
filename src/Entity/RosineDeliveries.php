<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineDeliveries
 *
 * @ORM\Table(name="rosine_deliveries")
 * @ORM\Entity
 */
class RosineDeliveries
{
    /**
     * @var bool
     *
     * @ORM\Column(name="COMPANY_ID", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $companyId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="DELIVERY_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $deliveryId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DELIVERY_DATE", type="date", nullable=true)
     */
    private $deliveryDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DELIVERY_CUSTOMER", type="integer", nullable=true)
     */
    private $deliveryCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="DELIVERY_CUSTOMER_PRIVATE", type="boolean", nullable=false, options={"default"="1"})
     */
    private $deliveryCustomerPrivate = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DELIVERY_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $deliveryAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DELIVERY_AMMOUNT_BRUTTO", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $deliveryAmmountBrutto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DELIVERY_NOTE", type="text", length=65535, nullable=true)
     */
    private $deliveryNote;

    /**
     * @var string
     *
     * @ORM\Column(name="DELIVERY_STATUS", type="string", length=10, nullable=false)
     */
    private $deliveryStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DELIVERY_TEMPLATE", type="string", length=250, nullable=true)
     */
    private $deliveryTemplate;

    /**
     * @var bool
     *
     * @ORM\Column(name="DELIVERY_PRINTED", type="boolean", nullable=false)
     */
    private $deliveryPrinted = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="GENERATED", type="string", length=100, nullable=true)
     */
    private $generated;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CHANGED", type="string", length=100, nullable=true)
     */
    private $changed;

    public function getCompanyId(): ?bool
    {
        return $this->companyId;
    }

    public function getDeliveryId(): ?int
    {
        return $this->deliveryId;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryCustomer(): ?int
    {
        return $this->deliveryCustomer;
    }

    public function setDeliveryCustomer(?int $deliveryCustomer): self
    {
        $this->deliveryCustomer = $deliveryCustomer;

        return $this;
    }

    public function getDeliveryCustomerPrivate(): ?bool
    {
        return $this->deliveryCustomerPrivate;
    }

    public function setDeliveryCustomerPrivate(bool $deliveryCustomerPrivate): self
    {
        $this->deliveryCustomerPrivate = $deliveryCustomerPrivate;

        return $this;
    }

    public function getDeliveryAmmount(): ?string
    {
        return $this->deliveryAmmount;
    }

    public function setDeliveryAmmount(?string $deliveryAmmount): self
    {
        $this->deliveryAmmount = $deliveryAmmount;

        return $this;
    }

    public function getDeliveryAmmountBrutto(): ?string
    {
        return $this->deliveryAmmountBrutto;
    }

    public function setDeliveryAmmountBrutto(?string $deliveryAmmountBrutto): self
    {
        $this->deliveryAmmountBrutto = $deliveryAmmountBrutto;

        return $this;
    }

    public function getDeliveryNote(): ?string
    {
        return $this->deliveryNote;
    }

    public function setDeliveryNote(?string $deliveryNote): self
    {
        $this->deliveryNote = $deliveryNote;

        return $this;
    }

    public function getDeliveryStatus(): ?string
    {
        return $this->deliveryStatus;
    }

    public function setDeliveryStatus(string $deliveryStatus): self
    {
        $this->deliveryStatus = $deliveryStatus;

        return $this;
    }

    public function getDeliveryTemplate(): ?string
    {
        return $this->deliveryTemplate;
    }

    public function setDeliveryTemplate(?string $deliveryTemplate): self
    {
        $this->deliveryTemplate = $deliveryTemplate;

        return $this;
    }

    public function getDeliveryPrinted(): ?bool
    {
        return $this->deliveryPrinted;
    }

    public function setDeliveryPrinted(bool $deliveryPrinted): self
    {
        $this->deliveryPrinted = $deliveryPrinted;

        return $this;
    }

    public function getGenerated(): ?string
    {
        return $this->generated;
    }

    public function setGenerated(?string $generated): self
    {
        $this->generated = $generated;

        return $this;
    }

    public function getChanged(): ?string
    {
        return $this->changed;
    }

    public function setChanged(?string $changed): self
    {
        $this->changed = $changed;

        return $this;
    }


}
