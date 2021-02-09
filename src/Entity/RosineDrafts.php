<?php

namespace App\Entity;

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

    public function getCompanyId(): ?bool
    {
        return $this->companyId;
    }

    public function getDraftId(): ?int
    {
        return $this->draftId;
    }

    public function getDraftDate(): ?\DateTimeInterface
    {
        return $this->draftDate;
    }

    public function setDraftDate(?\DateTimeInterface $draftDate): self
    {
        $this->draftDate = $draftDate;

        return $this;
    }

    public function getDraftCustomer(): ?int
    {
        return $this->draftCustomer;
    }

    public function setDraftCustomer(?int $draftCustomer): self
    {
        $this->draftCustomer = $draftCustomer;

        return $this;
    }

    public function getDraftCustomerPrivate(): ?bool
    {
        return $this->draftCustomerPrivate;
    }

    public function setDraftCustomerPrivate(bool $draftCustomerPrivate): self
    {
        $this->draftCustomerPrivate = $draftCustomerPrivate;

        return $this;
    }

    public function getDraftAmmount(): ?string
    {
        return $this->draftAmmount;
    }

    public function setDraftAmmount(?string $draftAmmount): self
    {
        $this->draftAmmount = $draftAmmount;

        return $this;
    }

    public function getDraftAmmountBrutto(): ?string
    {
        return $this->draftAmmountBrutto;
    }

    public function setDraftAmmountBrutto(?string $draftAmmountBrutto): self
    {
        $this->draftAmmountBrutto = $draftAmmountBrutto;

        return $this;
    }

    public function getDraftNote(): ?string
    {
        return $this->draftNote;
    }

    public function setDraftNote(?string $draftNote): self
    {
        $this->draftNote = $draftNote;

        return $this;
    }

    public function getDraftStatus(): ?string
    {
        return $this->draftStatus;
    }

    public function setDraftStatus(string $draftStatus): self
    {
        $this->draftStatus = $draftStatus;

        return $this;
    }

    public function getDraftTemplate(): ?string
    {
        return $this->draftTemplate;
    }

    public function setDraftTemplate(?string $draftTemplate): self
    {
        $this->draftTemplate = $draftTemplate;

        return $this;
    }

    public function getDraftPrinted(): ?bool
    {
        return $this->draftPrinted;
    }

    public function setDraftPrinted(bool $draftPrinted): self
    {
        $this->draftPrinted = $draftPrinted;

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
