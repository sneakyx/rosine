<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RosineNotes
 *
 * @ORM\Table(name="rosine_notes")
 * @ORM\Entity
 */
class RosineNotes
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

    public function getNoteId(): ?int
    {
        return $this->noteId;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getNoteText(): ?string
    {
        return $this->noteText;
    }

    public function setNoteText(?string $noteText): self
    {
        $this->noteText = $noteText;

        return $this;
    }


}
