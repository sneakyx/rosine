<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="rosine_locations")
 * @ORM\Entity
 */
class Location
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


}
