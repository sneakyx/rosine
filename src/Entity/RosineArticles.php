<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineArticles
 *
 * @ORM\Table(name="rosine_articles")
 * @ORM\Entity
 */
class RosineArticles
{
    /**
     * @var string
     *
     * @ORM\Column(name="ART_NUMBER", type="string", length=40, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $artNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="ART_NAME", type="string", length=255, nullable=false)
     */
    private $artName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_UNIT", type="string", length=20, nullable=true)
     */
    private $artUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_PRICE", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $artPrice;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ART_TAX", type="boolean", nullable=true, options={"default"="1"})
     */
    private $artTax = true;

    /**
     * @var int
     *
     * @ORM\Column(name="ART_STOCKNR", type="smallint", nullable=false, options={"default"="1"})
     */
    private $artStocknr = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ART_INSTOCK", type="integer", nullable=true)
     */
    private $artInstock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_NOTE", type="string", length=1100, nullable=true)
     */
    private $artNote;

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

    public function getArtNumber(): ?string
    {
        return $this->artNumber;
    }

    public function getArtName(): ?string
    {
        return $this->artName;
    }

    public function setArtName(string $artName): self
    {
        $this->artName = $artName;

        return $this;
    }

    public function getArtUnit(): ?string
    {
        return $this->artUnit;
    }

    public function setArtUnit(?string $artUnit): self
    {
        $this->artUnit = $artUnit;

        return $this;
    }

    public function getArtPrice(): ?string
    {
        return $this->artPrice;
    }

    public function setArtPrice(?string $artPrice): self
    {
        $this->artPrice = $artPrice;

        return $this;
    }

    public function getArtTax(): ?bool
    {
        return $this->artTax;
    }

    public function setArtTax(?bool $artTax): self
    {
        $this->artTax = $artTax;

        return $this;
    }

    public function getArtStocknr(): ?int
    {
        return $this->artStocknr;
    }

    public function setArtStocknr(int $artStocknr): self
    {
        $this->artStocknr = $artStocknr;

        return $this;
    }

    public function getArtInstock(): ?int
    {
        return $this->artInstock;
    }

    public function setArtInstock(?int $artInstock): self
    {
        $this->artInstock = $artInstock;

        return $this;
    }

    public function getArtNote(): ?string
    {
        return $this->artNote;
    }

    public function setArtNote(?string $artNote): self
    {
        $this->artNote = $artNote;

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
