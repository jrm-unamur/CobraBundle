<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 12/02/14
 * Time: 12:14
 */

namespace Unamur\CobraBundle\Entity;

use Unamur\CobraBundle\Lib\ElexRemoteService;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Unamur\CobraBundle\Repository\CobraCollectionRepository")
 * @ORM\Table(name="unamur_cobra_collection")
 */
class CobraCollection
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
     * @ORM\Column(name="name", length=64)
     */
    protected $name;

    /**
     * @ORM\Column(name="remote_name", length=64)
     */
    protected $remoteName;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    protected $visible;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Unamur\CobraBundle\Entity\CobraText",
     *     mappedBy="collection"
     * )
     */
    protected $cobraTexts;

    protected $remoteTexts;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Unamur\CobraBundle\Entity\CobraViewer",
     *     inversedBy="cobraCollections"
     * )
     * @ORM\JoinColumn(name="cobra_viewer_id", onDelete="CASCADE", nullable=false)
     */
    protected $cobraViewer;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Unamur\CobraBundle\Entity\CobraRemoteCollection",
     *     inversedBy="localInstances"
     * )
     * @ORM\JoinColumn(name="remote_id", onDelete="CASCADE", nullable=false)
     */
    protected $remoteCollection;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User"
     * )
     * @ORM\JoinColumn(name="creator_id", onDelete="CASCADE", nullable=false)
     */
    protected $creator;

    function __construct()
    {
        $this->position = 0;
    }

    /**
     * @param mixed $cobraViewer
     */
    public function setCobraViewer($cobraViewer)
    {
        $this->cobraViewer = $cobraViewer;
    }

    /**
     * @return mixed
     */
    public function getCobraViewer()
    {
        return $this->cobraViewer;
    }

    /**
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
     * @param mixed $remoteName
     */
    public function setRemoteName($remoteName)
    {
        $this->remoteName = $remoteName;
    }

    /**
     * @return mixed
     */
    public function getRemoteName()
    {
        return $this->remoteName;
    }

    /**
     * @param mixed $remoteTexts
     */
    public function setRemoteTexts($remoteTexts)
    {
        $this->remoteTexts = $remoteTexts;
    }

    /**
     * @return mixed
     */
    public function getRemoteTexts()
    {
        return ElexRemoteService::getRemoteTextList($this->getRemoteId());
    }

    public function getRemoteData()
    {
        $params = array( 'id_collection' => $this->remoteId );
        $remoteCollection = ElexRemoteService::call( 'getCollection', $params );
        $this->setRemoteName( $remoteCollection->label );
        $this->setName( $remoteCollection->label );
    }

    /**
     * @param mixed $texts
     */
    public function setCobraTexts($texts)
    {
        $this->cobraTexts = $texts;
    }

    /**
     * @return mixed
     */
    public function getCobraTexts()
    {
        return $this->cobraTexts;
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



} 