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
     * @ORM\Column(name="COMPANY_ID", type="integer", nullable=false)
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

    /**
     * @return int|null
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
     * @return \DateTimeInterface|null
     */
    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    /**
     * @param \DateTimeInterface|null $deliveryDate
     * @return $this
     */
    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDeliveryCustomer(): ?int
    {
        return $this->deliveryCustomer;
    }

    /**
     * @param int|null $deliveryCustomer
     * @return $this
     */
    public function setDeliveryCustomer(?int $deliveryCustomer): self
    {
        $this->deliveryCustomer = $deliveryCustomer;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDeliveryCustomerPrivate(): ?bool
    {
        return $this->deliveryCustomerPrivate;
    }

    /**
     * @param bool $deliveryCustomerPrivate
     * @return $this
     */
    public function setDeliveryCustomerPrivate(bool $deliveryCustomerPrivate): self
    {
        $this->deliveryCustomerPrivate = $deliveryCustomerPrivate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryAmmount(): ?string
    {
        return $this->deliveryAmmount;
    }

    /**
     * @param string|null $deliveryAmmount
     * @return $this
     */
    public function setDeliveryAmmount(?string $deliveryAmmount): self
    {
        $this->deliveryAmmount = $deliveryAmmount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryAmmountBrutto(): ?string
    {
        return $this->deliveryAmmountBrutto;
    }

    /**
     * @param string|null $deliveryAmmountBrutto
     * @return $this
     */
    public function setDeliveryAmmountBrutto(?string $deliveryAmmountBrutto): self
    {
        $this->deliveryAmmountBrutto = $deliveryAmmountBrutto;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryNote(): ?string
    {
        return $this->deliveryNote;
    }

    /**
     * @param string|null $deliveryNote
     * @return $this
     */
    public function setDeliveryNote(?string $deliveryNote): self
    {
        $this->deliveryNote = $deliveryNote;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryStatus(): ?string
    {
        return $this->deliveryStatus;
    }

    /**
     * @param string $deliveryStatus
     * @return $this
     */
    public function setDeliveryStatus(string $deliveryStatus): self
    {
        $this->deliveryStatus = $deliveryStatus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryTemplate(): ?string
    {
        return $this->deliveryTemplate;
    }

    /**
     * @param string|null $deliveryTemplate
     * @return $this
     */
    public function setDeliveryTemplate(?string $deliveryTemplate): self
    {
        $this->deliveryTemplate = $deliveryTemplate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDeliveryPrinted(): ?bool
    {
        return $this->deliveryPrinted;
    }

    /**
     * @param bool $deliveryPrinted
     * @return $this
     */
    public function setDeliveryPrinted(bool $deliveryPrinted): self
    {
        $this->deliveryPrinted = $deliveryPrinted;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGenerated(): ?string
    {
        return $this->generated;
    }

    /**
     * @param string|null $generated
     * @return $this
     */
    public function setGenerated(?string $generated): self
    {
        $this->generated = $generated;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChanged(): ?string
    {
        return $this->changed;
    }

    /**
     * @param string|null $changed
     * @return $this
     */
    public function setChanged(?string $changed): self
    {
        $this->changed = $changed;

        return $this;
    }


}
