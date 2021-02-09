<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosinePayments
 *
 * @ORM\Table(name="rosine_payments")
 * @ORM\Entity
 */
class RosinePayments
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
     * @ORM\Column(name="PAYMENT_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $paymentId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="INVOICE_ID", type="integer", nullable=true)
     */
    private $invoiceId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PAYMENT_DATE", type="date", nullable=true)
     */
    private $paymentDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="METH_ID", type="integer", nullable=true)
     */
    private $methId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PAYMENT_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $paymentAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PAYMENT_NOTE", type="string", length=512, nullable=true)
     */
    private $paymentNote;

    public function getCompanyId(): ?bool
    {
        return $this->companyId;
    }

    public function getPaymentId(): ?int
    {
        return $this->paymentId;
    }

    public function getInvoiceId(): ?int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(?int $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getMethId(): ?int
    {
        return $this->methId;
    }

    public function setMethId(?int $methId): self
    {
        $this->methId = $methId;

        return $this;
    }

    public function getPaymentAmmount(): ?string
    {
        return $this->paymentAmmount;
    }

    public function setPaymentAmmount(?string $paymentAmmount): self
    {
        $this->paymentAmmount = $paymentAmmount;

        return $this;
    }

    public function getPaymentNote(): ?string
    {
        return $this->paymentNote;
    }

    public function setPaymentNote(?string $paymentNote): self
    {
        $this->paymentNote = $paymentNote;

        return $this;
    }


}
