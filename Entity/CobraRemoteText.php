<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 13/03/14
 * Time: 14:42
 */

namespace Unamur\CobraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="unamur_cobra_remote_text")
 */
class CobraRemoteText
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", length=256)
     */
    protected $title;

    /**
     * @ORM\Column(name="source", length=256)
     */
    protected $source;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Unamur\CobraBundle\Entity\CobraRemoteCollection",
     *     inversedBy="cobraRemoteTexts"
     * )
     * @ORM\JoinColumn(name="collection_id", onDelete="CASCADE", nullable=false)
     */
    protected $remoteCollection;

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
     * @param mixed $remoteCollection
     */
    public function setRemoteCollection($remoteCollection)
    {
        $this->remoteCollection = $remoteCollection;
    }

    /**
     * @return mixed
     */
    public function getRemoteCollection()
    {
        return $this->remoteCollection;
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

} 