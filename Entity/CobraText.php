<?php
/**
 * This file is part of the CoBRA bundle for Claroline Connect.
 * 
 * (c) University of Namur (Cellule TICE) <tice@unamur.be>
 * Author: jmeuriss
 * Date: 29/11/13
 * Time: 14:57
 */

namespace JrmUnamur\CobraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CobraText
 * @ORM\Entity(repositoryClass="Unamur\CobraBundle\Repository\CobraTextRepository")
 * @ORM\Table(name="unamur_cobra_text")
 */
class CobraText
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="remote_id", type="integer", nullable=false)
     */
    protected $remoteId;

    /**
     * @ORM\Column(name="text_type", length=16, nullable=false)
     */
    protected $textType;

    /**
     * @ORM\Column(name="title", length=256)
     */
    protected $title;

    /**
     * @ORM\Column(name="source", length=256)
     */
    protected $source;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    protected $visible;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="JrmUnamur\CobraBundle\Entity\CobraCollection",
     *     inversedBy="cobraTexts"
     * )
     * @ORM\JoinColumn(name="collection_id", onDelete="CASCADE", nullable=false)
     */
    protected $collection;

    function __construct()
    {
        $this->textType = "Lesson";
        $this->title = '';
        $this->visible = false;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $textType
     */
    public function setTextType($textType)
    {
        $this->textType = $textType;
    }

    /**
     * @return mixed
     */
    public function getTextType()
    {
        return $this->textType;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $remoteId
     */
    public function setRemoteId($remoteId)
    {
        $this->remoteId = $remoteId;
    }

    /**
     * @return mixed
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return mixed
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

} 