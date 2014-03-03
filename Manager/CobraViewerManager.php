<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 26/02/14
 * Time: 15:25
 */

namespace JrmUnamur\CobraBundle\Manager;

use JrmUnamur\CobraBundle\Entity\CobraViewer;
use JrmUnamur\CobraBundle\Entity\CobraCollection;
use JrmUnamur\CobraBundle\Entity\CobraText;
use JrmUnamur\CobraBundle\Repository\CobraCollectionRepository;
use JrmUnamur\CobraBundle\Lib\ElexRemoteService;

use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;


/**
 * @DI\Service("jrmunamur.cobra.manager.cobra_manager")
 */
class CobraViewerManager
{
    /** @var CobraCollectionRepository */
    private $collectionRepository;
    private $om;

    /**
     * Constructor;
     *
     * @DI\InjectParams({ "om" = @DI\Inject("claroline.persistence.object_manager")})
     */
    public function __construct(ObjectManager $om)
    {
        $this->collectionRepository = $om->getRepository('JrmUnamurCobraBundle:CobraCollection');
        $this->om = $om;
    }

    public function registerCollection(CobraCollection $collection)
    {
        $collection->getRemoteData();
        $collection->setVisible(false);
        $collection->setPosition($collection->getCobraViewer()->getMaxPosition() + 1);
        $this->om->persist($collection);

        $index = 0;
        foreach($collection->getRemoteTexts() as $remoteText)
        {
            $text = new CobraText();
            $text->setCollection($collection);
            $text->setTitle($remoteText['title']);
            $text->setRemoteId($remoteText['id']);
            $text->setSource($remoteText['source']);
            $text->setTextType('Lesson');
            $text->setPosition(++$index);
            $text->setVisible(true);
            $this->om->persist($text);
        }

        $this->om->flush();
    }

    public function unregisterCollection(CobraCollection $collection)
    {
        $this->om->remove($collection);
        $this->om->flush();
    }

    public function getRegisteredCollectionsOfViewer(CobraViewer $viewer)
    {
        return $this->collectionRepository->findRegisteredCollectionsOfViewer($viewer);
    }

    public function getUnregisteredCollectionsForViewer(CobraViewer $viewer)
    {
        $registeredCollectionsIdList = array();
        foreach($viewer->getCobraCollections() as $collection)
        {
            $registeredCollectionsIdList[] = $collection->getRemoteId();
        }
        $unregisteredCollections = array();
        $params = array('language' => $viewer->getLanguage());
        $collectionsObjectList = ElexRemoteService::call('loadFilteredCollections', $params);
        foreach($collectionsObjectList as $remoteCollection)
        {
            if(in_array($remoteCollection->id, $registeredCollectionsIdList)) continue;
            $collection = new CobraCollection();
            $collection->setRemoteId($remoteCollection->id);
            $collection->setName($remoteCollection->label);
            $unregisteredCollections[] = $collection;
        }
        return $unregisteredCollections;
    }

    public function getTextDisplay(CobraText $text)
    {
        $params = array('id_text' => $text->getRemoteId());
        return ElexRemoteService::call('getFormattedText', $params);
    }



    public function isAlreadyRegistered(CobraCollection $collection)
    {
        return $this->collectionRepository->isAlreadyRegistered($collection);
    }
} 