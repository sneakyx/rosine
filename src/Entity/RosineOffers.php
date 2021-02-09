<?php

namespace App\Entity;

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

    public function getCompanyId(): ?bool
    {
        return $this->companyId;
    }

    public function getOfferId(): ?int
    {
        return $this->offerId;
    }

    public function getOfferDate(): ?\DateTimeInterface
    {
        return $this->offerDate;
    }

    public function setOfferDate(?\DateTimeInterface $offerDate): self
    {
        $this->offerDate = $offerDate;

        return $this;
    }

    public function getOfferCustomer(): ?int
    {
        return $this->offerCustomer;
    }

    public function setOfferCustomer(?int $offerCustomer): self
    {
        $this->offerCustomer = $offerCustomer;

        return $this;
    }

    public function getOfferCustomerPrivate(): ?bool
    {
        return $this->offerCustomerPrivate;
    }

    public function setOfferCustomerPrivate(bool $offerCustomerPrivate): self
    {
        $this->offerCustomerPrivate = $offerCustomerPrivate;

        return $this;
    }

    public function getOfferAmmount(): ?string
    {
        return $this->offerAmmount;
    }

    public function setOfferAmmount(?string $offerAmmount): self
    {
        $this->offerAmmount = $offerAmmount;

        return $this;
    }

    public function getOfferAmmountBrutto(): ?string
    {
        return $this->offerAmmountBrutto;
    }

    public function setOfferAmmountBrutto(?string $offerAmmountBrutto): self
    {
        $this->offerAmmountBrutto = $offerAmmountBrutto;

        return $this;
    }

    public function getOfferNote(): ?string
    {
        return $this->offerNote;
    }

    public function setOfferNote(?string $offerNote): self
    {
        $this->offerNote = $offerNote;

        return $this;
    }

    public function getOfferStatus(): ?string
    {
        return $this->offerStatus;
    }

    public function setOfferStatus(string $offerStatus): self
    {
        $this->offerStatus = $offerStatus;

        return $this;
    }

    public function getOfferTemplate(): ?string
    {
        return $this->offerTemplate;
    }

    public function setOfferTemplate(?string $offerTemplate): self
    {
        $this->offerTemplate = $offerTemplate;

        return $this;
    }

    public function getOfferPrinted(): ?bool
    {
        return $this->offerPrinted;
    }

    public function setOfferPrinted(?bool $offerPrinted): self
    {
        $this->offerPrinted = $offerPrinted;

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
