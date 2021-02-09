<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineTaxes
 *
 * @ORM\Table(name="rosine_taxes")
 * @ORM\Entity
 */
class RosineTaxes
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

    public function getTaxId(): ?bool
    {
        return $this->taxId;
    }

    public function getTaxName(): ?string
    {
        return $this->taxName;
    }

    public function setTaxName(?string $taxName): self
    {
        $this->taxName = $taxName;

        return $this;
    }

    public function getTaxPercentage(): ?string
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(string $taxPercentage): self
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    public function getGenerated(): ?string
    {
        return $this->generated;
    }

    public function setGenerated(string $generated): self
    {
        $this->generated = $generated;

        return $this;
    }

    public function getChanged(): ?string
    {
        return $this->changed;
    }

    public function setChanged(string $changed): self
    {
        $this->changed = $changed;

        return $this;
    }


}
