<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RosineOffers
 *
 * @ORM\Table(name="rosine_offers")
 * @ORM\Entity
 */
class RosineOffers
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
     * @ORM\Column(name="OFFER_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $offerId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="OFFER_DATE", type="date", nullable=true)
     */
    private $offerDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="OFFER_CUSTOMER", type="integer", nullable=true)
     */
    private $offerCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="OFFER_CUSTOMER_PRIVATE", type="boolean", nullable=false, options={"default"="1"})
     */
    private $offerCustomerPrivate = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="OFFER_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $offerAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="OFFER_AMMOUNT_BRUTTO", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $offerAmmountBrutto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="OFFER_NOTE", type="string", length=1100, nullable=true)
     */
    private $offerNote;

    /**
     * @var string
     *
     * @ORM\Column(name="OFFER_STATUS", type="string", length=10, nullable=false)
     */
    private $offerStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="OFFER_TEMPLATE", type="string", length=250, nullable=true)
     */
    private $offerTemplate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="OFFER_PRINTED", type="boolean", nullable=true)
     */
    private $offerPrinted = '0';

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
