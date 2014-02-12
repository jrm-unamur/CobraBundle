<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 7/02/14
 * Time: 14:51
 */

namespace JrmUnamur\CobraBundle\Entity;

use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Doctrine\ORM\Mapping as ORM;


/**
 * JrmUnamur\CobraBundle\Entity\CobraViewer
 *
 * @ORM\Entity
 * @ORM\Table(name="unamur_cobra_viewer")
 */
class CobraViewer extends AbstractResource
{
    /**
     * @ORM\OneToMany(
     *      targetEntity="JrmUnamur\CobraBundle\Entity\CobraCollection",
     *      mappedBy="cobraViewer"
     */
    protected $cobraCollections;

    /**
     * @var string language
     *
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language;

    /**
     * @var boolean $displayGender
     *
     * @ORM\Column(name="display_gender", type="boolean", nullable=false)
     */
    private $displayGender;

    /**
     * @var boolean $displayInflectedForms
     *
     * @ORM\Column(name="display_inflected_forms", type="boolean", nullable=false)
     */
    private $displayInflectedForms;

    /**
     * @var string $translationsDisplayMode
     *
     * @ORM\Column(name="translations_display_mode", type="string", length=10, nullable=false)
     */
    private $translationsDisplayMode;

    /**
     * @var boolean $displayIllustrations
     *
     * @ORM\Column(name="display_illustrations", type="boolean", nullable=false)
     */
    private $displayIllustrations;

    /**
     * @var string $examplesDisplayMode
     *
     * @ORM\Column(name="examples_display_mode", type="string", length=16)
     */
    private $examplesDisplayMode;

    /**
     * @var boolean $displayOccurrences
     *
     * @ORM\Column(name="display_occurrences", type="boolean", nullable=false)
     */
    private $displayOccurrences;

    /**
     * @var string $descriptionsDisplayModeµ
     *
     * @ORM\Column(name="descriptions_display_mode", type="string", length=16, nullable=false)
     */
    private $descriptionsDisplayMode;

    /**
     * @var boolean $showMediaPlayer
     *
     * @ORM\Column(name="show_media_player", type="boolean", nullable=false)
     */
    private $showMediaPlayer;

    /**
     * @var string $corpusDisplayOrder
     *
     * @ORM\Column(name="corpus_display_order", length=32, nullable=true)
     */
    private $corpusDisplayOrder;

    function __construct()
    {
        $this->language = "EN";
        $this->displayGender = false;
        $this->displayInflectedForms = false;
        $this->translationsDisplayMode = 'conditional';
        $this->displayIllustrations = false;
        $this->examplesDisplayMode = 'bi-text';
        $this->displayOccurrences = true;
        $this->descriptionsDisplayMode = 'conditional';
        $this->showMediaPlayer = true;
    }

    public function getCobraCollections()
    {
        return $this->cobraCollections;
    }

    /**
     * @param mixed $corpusDisplayOrder
     */
    public function setCorpusDisplayOrder($corpusDisplayOrder)
    {
        $this->corpusDisplayOrder = $corpusDisplayOrder;
    }

    /**
     * @return mixed
     */
    public function getCorpusDisplayOrder()
    {
        return $this->corpusDisplayOrder;
    }

    /**
     * @param mixed $descriptionsDisplayMode
     */
    public function setDescriptionsDisplayMode($descriptionsDisplayMode)
    {
        $this->descriptionsDisplayMode = $descriptionsDisplayMode;
    }

    /**
     * @return mixed
     */
    public function getDescriptionsDisplayMode()
    {
        return $this->descriptionsDisplayMode;
    }

    /**
     * @param boolean $displayGender
     */
    public function setDisplayGender($displayGender)
    {
        $this->displayGender = $displayGender;
    }

    /**
     * @return boolean
     */
    public function getDisplayGender()
    {
        return $this->displayGender;
    }

    /**
     * @param mixed $displayIllustrations
     */
    public function setDisplayIllustrations($displayIllustrations)
    {
        $this->displayIllustrations = $displayIllustrations;
    }

    /**
     * @return mixed
     */
    public function getDisplayIllustrations()
    {
        return $this->displayIllustrations;
    }

    /**
     * @param boolean $displayInflectedForms
     */
    public function setDisplayInflectedForms($displayInflectedForms)
    {
        $this->displayInflectedForms = $displayInflectedForms;
    }

    /**
     * @return boolean
     */
    public function getDisplayInflectedForms()
    {
        return $this->displayInflectedForms;
    }

    /**
     * @param mixed $displayOccurrences
     */
    public function setDisplayOccurrences($displayOccurrences)
    {
        $this->displayOccurrences = $displayOccurrences;
    }

    /**
     * @return mixed
     */
    public function getDisplayOccurrences()
    {
        return $this->displayOccurrences;
    }

    /**
     * @param mixed $examplesDisplayMode
     */
    public function setExamplesDisplayMode($examplesDisplayMode)
    {
        $this->examplesDisplayMode = $examplesDisplayMode;
    }

    /**
     * @return mixed
     */
    public function getExamplesDisplayMode()
    {
        return $this->examplesDisplayMode;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $showMediaPlayer
     */
    public function setShowMediaPlayer($showMediaPlayer)
    {
        $this->showMediaPlayer = $showMediaPlayer;
    }

    /**
     * @return mixed
     */
    public function getShowMediaPlayer()
    {
        return $this->showMediaPlayer;
    }

    /**
     * @param mixed $translationsDisplayMode
     */
    public function setTranslationsDisplayMode($translationsDisplayMode)
    {
        $this->translationsDisplayMode = $translationsDisplayMode;
    }

    /**
     * @return mixed
     */
    public function getTranslationsDisplayMode()
    {
        return $this->translationsDisplayMode;
    }



} 