<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineInvoices
 *
 * @ORM\Table(name="rosine_invoices")
 * @ORM\Entity
 */
class RosineInvoices
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="INVOICE_DATE", type="date", nullable=true)
     */
    private $invoiceDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="INVOICE_CUSTOMER", type="integer", nullable=true)
     */
    private $invoiceCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="INVOICE_CUSTOMER_PRIVATE", type="boolean", nullable=false, options={"default"="1"})
     */
    private $invoiceCustomerPrivate = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INVOICE_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $invoiceAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INVOICE_AMMOUNT_BRUTTO", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $invoiceAmmountBrutto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INVOICE_NOTE", type="text", length=65535, nullable=true)
     */
    private $invoiceNote;

    /**
     * @var string
     *
     * @ORM\Column(name="INVOICE_STATUS", type="string", length=10, nullable=false)
     */
    private $invoiceStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INVOICE_TEMPLATE", type="string", length=250, nullable=true)
     */
    private $invoiceTemplate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="INVOICE_PRINTED", type="boolean", nullable=true)
     */
    private $invoicePrinted = '0';

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

    public function getInvoiceId(): ?int
    {
        return $this->invoiceId;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(?\DateTimeInterface $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getInvoiceCustomer(): ?int
    {
        return $this->invoiceCustomer;
    }

    public function setInvoiceCustomer(?int $invoiceCustomer): self
    {
        $this->invoiceCustomer = $invoiceCustomer;

        return $this;
    }

    public function getInvoiceCustomerPrivate(): ?bool
    {
        return $this->invoiceCustomerPrivate;
    }

    public function setInvoiceCustomerPrivate(bool $invoiceCustomerPrivate): self
    {
        $this->invoiceCustomerPrivate = $invoiceCustomerPrivate;

        return $this;
    }

    public function getInvoiceAmmount(): ?string
    {
        return $this->invoiceAmmount;
    }

    public function setInvoiceAmmount(?string $invoiceAmmount): self
    {
        $this->invoiceAmmount = $invoiceAmmount;

        return $this;
    }

    public function getInvoiceAmmountBrutto(): ?string
    {
        return $this->invoiceAmmountBrutto;
    }

    public function setInvoiceAmmountBrutto(?string $invoiceAmmountBrutto): self
    {
        $this->invoiceAmmountBrutto = $invoiceAmmountBrutto;

        return $this;
    }

    public function getInvoiceNote(): ?string
    {
        return $this->invoiceNote;
    }

    public function setInvoiceNote(?string $invoiceNote): self
    {
        $this->invoiceNote = $invoiceNote;

        return $this;
    }

    public function getInvoiceStatus(): ?string
    {
        return $this->invoiceStatus;
    }

    public function setInvoiceStatus(string $invoiceStatus): self
    {
        $this->invoiceStatus = $invoiceStatus;

        return $this;
    }

    public function getInvoiceTemplate(): ?string
    {
        return $this->invoiceTemplate;
    }

    public function setInvoiceTemplate(?string $invoiceTemplate): self
    {
        $this->invoiceTemplate = $invoiceTemplate;

        return $this;
    }

    public function getInvoicePrinted(): ?bool
    {
        return $this->invoicePrinted;
    }

    public function setInvoicePrinted(?bool $invoicePrinted): self
    {
        $this->invoicePrinted = $invoicePrinted;

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
