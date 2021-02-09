<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineOrders
 *
 * @ORM\Table(name="rosine_orders")
 * @ORM\Entity
 */
class RosineOrders
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
     * @ORM\Column(name="ORDER_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $orderId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ORDER_DATE", type="date", nullable=true)
     */
    private $orderDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ORDER_CUSTOMER", type="integer", nullable=true)
     */
    private $orderCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="ORDER_CUSTOMER_PRIVATE", type="boolean", nullable=false, options={"default"="1"})
     */
    private $orderCustomerPrivate = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ORDER_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $orderAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ORDER_AMMOUNT_BRUTTO", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $orderAmmountBrutto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ORDER_NOTE", type="string", length=1100, nullable=true)
     */
    private $orderNote;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_STATUS", type="string", length=10, nullable=false)
     */
    private $orderStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ORDER_TEMPLATE", type="string", length=250, nullable=true)
     */
    private $orderTemplate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ORDER_PRINTED", type="boolean", nullable=true)
     */
    private $orderPrinted = '0';

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

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOrderCustomer(): ?int
    {
        return $this->orderCustomer;
    }

    public function setOrderCustomer(?int $orderCustomer): self
    {
        $this->orderCustomer = $orderCustomer;

        return $this;
    }

    public function getOrderCustomerPrivate(): ?bool
    {
        return $this->orderCustomerPrivate;
    }

    public function setOrderCustomerPrivate(bool $orderCustomerPrivate): self
    {
        $this->orderCustomerPrivate = $orderCustomerPrivate;

        return $this;
    }

    public function getOrderAmmount(): ?string
    {
        return $this->orderAmmount;
    }

    public function setOrderAmmount(?string $orderAmmount): self
    {
        $this->orderAmmount = $orderAmmount;

        return $this;
    }

    public function getOrderAmmountBrutto(): ?string
    {
        return $this->orderAmmountBrutto;
    }

    public function setOrderAmmountBrutto(?string $orderAmmountBrutto): self
    {
        $this->orderAmmountBrutto = $orderAmmountBrutto;

        return $this;
    }

    public function getOrderNote(): ?string
    {
        return $this->orderNote;
    }

    public function setOrderNote(?string $orderNote): self
    {
        $this->orderNote = $orderNote;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getOrderTemplate(): ?string
    {
        return $this->orderTemplate;
    }

    public function setOrderTemplate(?string $orderTemplate): self
    {
        $this->orderTemplate = $orderTemplate;

        return $this;
    }

    public function getOrderPrinted(): ?bool
    {
        return $this->orderPrinted;
    }

    public function setOrderPrinted(?bool $orderPrinted): self
    {
        $this->orderPrinted = $orderPrinted;

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
