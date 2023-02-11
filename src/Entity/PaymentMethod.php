<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentMethod
 *
 * @ORM\Table(name="rosine_payments_methods")
 * @ORM\Entity
 */
class PaymentMethod
{
    /**
     * @var int
     *
     * @ORM\Column(name="METH_ID", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $methId;

    /**
     * @var string
     *
     * @ORM\Column(name="METH_NAME", type="string", length=255, nullable=false)
     */
    private $methName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="METH_NOTE", type="text", length=65535, nullable=true)
     */
    private $methNote;

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
