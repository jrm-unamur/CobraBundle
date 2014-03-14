<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 13/03/14
 * Time: 11:45
 */

namespace Unamur\CobraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Unamur\CobraBundle\Repository\CobraRemoteCollectionRepository")
 * @ORM\Table(name="unamur_cobra_remote_collection")
 */
class CobraRemoteCollection
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
 * @ORM\Column(name="name", length=64)
 */
    protected $name;

    /**
     * @ORM\Column(name="language", type="string", length=2)
     */
    protected $language;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Unamur\CobraBundle\Entity\CobraCollection",
     *      mappedBy="remoteCollection")
     */
    protected $localInstances;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Unamur\CobraBundle\Entity\CobraRemoteText",
     *     mappedBy="remoteCollection"
     * )
     */
    protected $cobraRemoteTexts;

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
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $cobraRemoteTexts
     */
    public function setCobraRemoteTexts($cobraRemoteTexts)
    {
        $this->cobraRemoteTexts = $cobraRemoteTexts;
    }

    /**
     * @return mixed
     */
    public function getCobraRemoteTexts()
    {
        return $this->cobraRemoteTexts;
    }
} 