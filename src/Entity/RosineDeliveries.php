<?php



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
     * @ORM\Column(name="COMPANY_ID", type="boolean", nullable=false, options={"default"="1"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $companyId = true;

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


}
