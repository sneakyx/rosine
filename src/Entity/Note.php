<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="rosine_notes")
 * @ORM\Entity
 */
class Note
{
    /**
     * @var int
     *
     * @ORM\Column(name="NOTE_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $noteId;

    /**
     * @var string
     *
     * @ORM\Column(name="LANGUAGE", type="string", length=60, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $language;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOTE_TEXT", type="text", length=65535, nullable=true)
     */
    private $noteText;


}
