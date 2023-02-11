<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RosineDrafts
 *
 * @ORM\Table(name="rosine_drafts")
 * @ORM\Entity
 */
class RosineDrafts
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
     * @ORM\Column(name="DRAFT_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $draftId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DRAFT_DATE", type="date", nullable=true)
     */
    private $draftDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DRAFT_CUSTOMER", type="integer", nullable=true)
     */
    private $draftCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="DRAFT_CUSTOMER_PRIVATE", type="boolean", nullable=false, options={"default"="1"})
     */
    private $draftCustomerPrivate = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DRAFT_AMMOUNT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $draftAmmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DRAFT_AMMOUNT_BRUTTO", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $draftAmmountBrutto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DRAFT_NOTE", type="text", length=65535, nullable=true)
     */
    private $draftNote;

    /**
     * @var string
     *
     * @ORM\Column(name="DRAFT_STATUS", type="string", length=10, nullable=false)
     */
    private $draftStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DRAFT_TEMPLATE", type="string", length=250, nullable=true)
     */
    private $draftTemplate;

    /**
     * @var bool
     *
     * @ORM\Column(name="DRAFT_PRINTED", type="boolean", nullable=false)
     */
    private $draftPrinted = '0';

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
