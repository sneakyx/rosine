<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 */
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: "rosine_articles")]
class Article
{
    /**
     * @var string
     */

    #[ORM\Column(name: "ART_NUMBER", type: "string", length: 40, nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private string $artNumber;

    /**
     * @var string
     */
    #[ORM\Column(name: "ART_NAME", type: "string", length: 255, nullable: false)]
    private string $artName;

    /**
     * @var string|null
     */
    #[ORM\Column(name: "ART_UNIT", type: "string", length: 20, nullable: true)]
    private ?string $artUnit;

    /**
     * @var string|null
     */
    #[ORM\Column(name: "ART_PRICE", type: "decimal", precision: 8, scale: 2, nullable: true)]
    private ?string $artPrice;

    /**
     * @var bool|null
     */

    #[ORM\Column(name: "ART_TAX", type: "boolean", nullable: true, options: ["default" => "1"])]
    private ?bool $artTax = true;

    /**
     * @var int
     */
    #[ORM\Column(name: "ART_STOCKNR", type: "smallint", nullable: false, options: ["default" => "1"])]
    private int $artStocknr = 1;

    /**
     * @var int|null
     */
    #[ORM\Column(name: "ART_INSTOCK", type: "integer ", nullable: true)]
    private ?int $artInstock;

    /**
     * @var string|null
     */
    #[ORM\Column(name: "ART_NOTE", type: "string", length: 1100, nullable: true)]
    private ?string $artNote;

    /**
     * @var string|null
     */
    #[ORM\Column(name: "GENERATED", type: "string", length: 100, nullable: true)]
    private ?string $generated;

    /**
     * @var string|null
     */
    #[ORM\Column(name: "CHANGED", type: "string", length: 100, nullable: true)]
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
    public function setArtNumber(string $artNumber): Article
    {
        $this->artNumber = $artNumber;
        return $this;
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
    public function setArtName(string $artName): Article
    {
        $this->artName = $artName;
        return $this;
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
    public function setArtUnit(?string $artUnit): Article
    {
        $this->artUnit = $artUnit;
        return $this;
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
    public function setArtPrice(?string $artPrice): Article
    {
        $this->artPrice = $artPrice;
        return $this;
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
    public function setArtTax(?bool $artTax): Article
    {
        $this->artTax = $artTax;
        return $this;
    }

    /**
     * @return int
     */
    public function getArtStocknr(): int
    {
        return $this->artStocknr;
    }

    /**
     * @param int $artStocknr
     */
    public function setArtStocknr(int $artStocknr): Article
    {
        $this->artStocknr = $artStocknr;
        return $this;
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
    public function setArtInstock(?int $artInstock): Article
    {
        $this->artInstock = $artInstock;
        return $this;
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
    public function setArtNote(?string $artNote): Article
    {
        $this->artNote = $artNote;
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
     */
    public function setGenerated(?string $generated): Article
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
     */
    public function setChanged(?string $changed): Article
    {
        $this->changed = $changed;
        return $this;
    }


}
