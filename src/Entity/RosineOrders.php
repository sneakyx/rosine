<?php



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


}
