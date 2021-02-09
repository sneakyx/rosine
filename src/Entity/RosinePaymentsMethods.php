<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosinePaymentsMethods
 *
 * @ORM\Table(name="rosine_payments_methods")
 * @ORM\Entity
 */
class RosinePaymentsMethods
{
    /**
     * @var int
     *
     * @ORM\Column(name="METH_ID", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $methId;

    /**
     * @var string
     *
     * @ORM\Column(name="METH_NAME", type="string", length=255, nullable=false)
     */
    private $methName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="METH_NOTE", type="text", length=65535, nullable=true)
     */
    private $methNote;

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

    public function getMethId(): ?int
    {
        return $this->methId;
    }

    public function getMethName(): ?string
    {
        return $this->methName;
    }

    public function setMethName(string $methName): self
    {
        $this->methName = $methName;

        return $this;
    }

    public function getMethNote(): ?string
    {
        return $this->methNote;
    }

    public function setMethNote(?string $methNote): self
    {
        $this->methNote = $methNote;

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
