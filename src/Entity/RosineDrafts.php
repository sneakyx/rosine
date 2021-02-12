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
     * @var int
     *
     * @ORM\Column(name="COMPANY_ID", type="integer", nullable=false, options={"default"="1"})
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

    /**
     * @return int|null
     */
    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    /**
     * @return int|null
     */
    public function getDraftId(): ?int
    {
        return $this->draftId;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDraftDate(): ?\DateTimeInterface
    {
        return $this->draftDate;
    }

    /**
     * @param \DateTimeInterface|null $draftDate
     * @return $this
     */
    public function setDraftDate(?\DateTimeInterface $draftDate): self
    {
        $this->draftDate = $draftDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDraftCustomer(): ?int
    {
        return $this->draftCustomer;
    }

    /**
     * @param int|null $draftCustomer
     * @return $this
     */
    public function setDraftCustomer(?int $draftCustomer): self
    {
        $this->draftCustomer = $draftCustomer;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDraftCustomerPrivate(): ?bool
    {
        return $this->draftCustomerPrivate;
    }

    /**
     * @param bool $draftCustomerPrivate
     * @return $this
     */
    public function setDraftCustomerPrivate(bool $draftCustomerPrivate): self
    {
        $this->draftCustomerPrivate = $draftCustomerPrivate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDraftAmmount(): ?string
    {
        return $this->draftAmmount;
    }

    /**
     * @param string|null $draftAmmount
     * @return $this
     */
    public function setDraftAmmount(?string $draftAmmount): self
    {
        $this->draftAmmount = $draftAmmount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDraftAmmountBrutto(): ?string
    {
        return $this->draftAmmountBrutto;
    }

    /**
     * @param string|null $draftAmmountBrutto
     * @return $this
     */
    public function setDraftAmmountBrutto(?string $draftAmmountBrutto): self
    {
        $this->draftAmmountBrutto = $draftAmmountBrutto;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDraftNote(): ?string
    {
        return $this->draftNote;
    }

    /**
     * @param string|null $draftNote
     * @return $this
     */
    public function setDraftNote(?string $draftNote): self
    {
        $this->draftNote = $draftNote;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDraftStatus(): ?string
    {
        return $this->draftStatus;
    }

    /**
     * @param string $draftStatus
     * @return $this
     */
    public function setDraftStatus(string $draftStatus): self
    {
        $this->draftStatus = $draftStatus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDraftTemplate(): ?string
    {
        return $this->draftTemplate;
    }

    /**
     * @param string|null $draftTemplate
     * @return $this
     */
    public function setDraftTemplate(?string $draftTemplate): self
    {
        $this->draftTemplate = $draftTemplate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDraftPrinted(): ?bool
    {
        return $this->draftPrinted;
    }

    /**
     * @param bool $draftPrinted
     * @return $this
     */
    public function setDraftPrinted(bool $draftPrinted): self
    {
        $this->draftPrinted = $draftPrinted;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGenerated(): ?string
    {
        return $this->generated;
    }

    /**
     * @param string|null $generated
     * @return $this
     */
    public function setGenerated(?string $generated): self
    {
        $this->generated = $generated;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChanged(): ?string
    {
        return $this->changed;
    }

    /**
     * @param string|null $changed
     * @return $this
     */
    public function setChanged(?string $changed): self
    {
        $this->changed = $changed;

        return $this;
    }


}
