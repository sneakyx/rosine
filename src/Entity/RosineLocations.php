<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineLocations
 *
 * @ORM\Table(name="rosine_locations")
 * @ORM\Entity
 */
class RosineLocations
{
    /**
     * @var int
     *
     * @ORM\Column(name="LOC_ID", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $locId;

    /**
     * @var string
     *
     * @ORM\Column(name="LOC_NAME", type="string", length=255, nullable=false)
     */
    private $locName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LOC_NOTE", type="string", length=1100, nullable=true)
     */
    private $locNote;

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

    public function getLocId(): ?int
    {
        return $this->locId;
    }

    public function getLocName(): ?string
    {
        return $this->locName;
    }

    public function setLocName(string $locName): self
    {
        $this->locName = $locName;

        return $this;
    }

    public function getLocNote(): ?string
    {
        return $this->locNote;
    }

    public function setLocNote(?string $locNote): self
    {
        $this->locNote = $locNote;

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
