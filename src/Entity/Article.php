<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="rosine_articles")
 * @ORM\Entity
 */
class Article
{
    /**
     * @var string
     *
     * @ORM\Column(name="ART_NUMBER", type="string", length=40, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private string $artNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="ART_NAME", type="string", length=255, nullable=false)
     */
    private string $artName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_UNIT", type="string", length=20, nullable=true)
     */
    private ?string $artUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_PRICE", type="decimal", precision=8, scale=2, nullable=true)
     */
    private ?string $artPrice;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ART_TAX", type="boolean", nullable=true, options={"default"="1"})
     */
    private ?bool $artTax = true;

    /**
     * @var int
     *
     * @ORM\Column(name="ART_STOCKNR", type="smallint", nullable=false, options={"default"="1"})
     */
    private string|int $artStocknr = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ART_INSTOCK", type="integer", nullable=true)
     */
    private ?int $artInstock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_NOTE", type="string", length=1100, nullable=true)
     */
    private ?string $artNote;

    /**
     * @var string|null
     *
     * @ORM\Column(name="GENERATED", type="string", length=100, nullable=true)
     */
    private ?string $generated;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CHANGED", type="string", length=100, nullable=true)
     */
    private ?string $changed;

    /**
     * @return string
     */
    public function getArtNumber(): string
    {
        return $this->artNumber;
    }

    /**
     * @param string $artNumber
     */
    public function setArtNumber(string $artNumber): void
    {
        $this->artNumber = $artNumber;
    }

    /**
     * @return string
     */
    public function getArtName(): string
    {
        return $this->artName;
    }

    /**
     * @param string $artName
     */
    public function setArtName(string $artName): void
    {
        $this->artName = $artName;
    }

    /**
     * @return string|null
     */
    public function getArtUnit(): ?string
    {
        return $this->artUnit;
    }

    /**
     * @param string|null $artUnit
     */
    public function setArtUnit(?string $artUnit): void
    {
        $this->artUnit = $artUnit;
    }

    /**
     * @return string|null
     */
    public function getArtPrice(): ?string
    {
        return $this->artPrice;
    }

    /**
     * @param string|null $artPrice
     */
    public function setArtPrice(?string $artPrice): void
    {
        $this->artPrice = $artPrice;
    }

    /**
     * @return bool|null
     */
    public function getArtTax(): ?bool
    {
        return $this->artTax;
    }

    /**
     * @param bool|null $artTax
     */
    public function setArtTax(?bool $artTax): void
    {
        $this->artTax = $artTax;
    }

    /**
     * @return int|string
     */
    public function getArtStocknr(): int|string
    {
        return $this->artStocknr;
    }

    /**
     * @param int|string $artStocknr
     */
    public function setArtStocknr(int|string $artStocknr): void
    {
        $this->artStocknr = $artStocknr;
    }

    /**
     * @return int|null
     */
    public function getArtInstock(): ?int
    {
        return $this->artInstock;
    }

    /**
     * @param int|null $artInstock
     */
    public function setArtInstock(?int $artInstock): void
    {
        $this->artInstock = $artInstock;
    }

    /**
     * @return string|null
     */
    public function getArtNote(): ?string
    {
        return $this->artNote;
    }

    /**
     * @param string|null $artNote
     */
    public function setArtNote(?string $artNote): void
    {
        $this->artNote = $artNote;
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
     */
    public function setGenerated(?string $generated): void
    {
        $this->generated = $generated;
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
     */
    public function setChanged(?string $changed): void
    {
        $this->changed = $changed;
    }


}
