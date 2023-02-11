<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="rosine_invoices")
 * @ORM\Entity
 */
class Invoice
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


}
