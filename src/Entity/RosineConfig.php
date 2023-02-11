<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RosineConfig
 *
 * @ORM\Table(name="rosine_config")
 * @ORM\Entity
 */
class RosineConfig
{
    /**
     * @var string
     *
     * @ORM\Column(name="config", type="string", length=60, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $config;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;


}
