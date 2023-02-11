<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineArticlesOld
 *
 * @ORM\Table(name="rosine_articles_old")
 * @ORM\Entity
 */
class RosineArticlesOld
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


}
