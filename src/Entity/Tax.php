<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Tax
 *
 * @ORM\Table(name="rosine_taxes")
 * @ORM\Entity
 */
class Tax
{
    /**
     * @var bool
     *
     * @ORM\Column(name="TAX_ID", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $taxId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TAX_NAME", type="string", length=20, nullable=true)
     */
    private $taxName;

    /**
     * @var string
     *
     * @ORM\Column(name="TAX_PERCENTAGE", type="decimal", precision=4, scale=2, nullable=false)
     */
    private $taxPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="GENERATED", type="string", length=100, nullable=false)
     */
    private $generated;

    /**
     * @var string
     *
     * @ORM\Column(name="CHANGED", type="string", length=100, nullable=false)
     */
    private $changed;


}
