<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="rosine_payments")
 * @ORM\Entity
 */
class Payment
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


}
