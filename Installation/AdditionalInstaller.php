<?php

namespace Unamur\CobraBundle\Installation;

use Claroline\InstallationBundle\Additional\AdditionalInstaller as BaseInstaller;
use Unamur\CobraBundle\Entity\CobraRemoteText;
use Unamur\CobraBundle\Lib\ElexRemoteService;
use Unamur\CobraBundle\Entity\CobraRemoteCollection;

/**
 * Executes correct action when PathBundle is installed or updated
 */
class AdditionalInstaller extends BaseInstaller
{
    /**
     * Action to perform after Bundle installation
     * Load default allowed types for the non digital resources
     * @return \Innova\PathBundle\Installation\AdditionalInstaller
     */
    public function postInstall()
    {
        $this->insertRemoteCollections();
        //$this->insertRemoteTexts();
        
        return $this;
    }
    
    /**
     * Insert allowed types for the non digital resources in the DB
     * @return \Innova\PathBundle\Installation\AdditionalInstaller
     */
    protected function insertRemoteCollections()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $collectionsObjectList = ElexRemoteService::call('loadAllCollections', array());
        foreach($collectionsObjectList as $remoteCollection)
        {
            $collection = new CobraRemoteCollection();
            $collection->setId($remoteCollection->id);
            $collection->setName($remoteCollection->label);
            $collection->setLanguage($remoteCollection->language);
            $em->persist($collection);
            $textsObjectList = ElexRemoteService::call('loadTexts', array( 'collection' => $collection->getId()));
            foreach($textsObjectList as $remoteText)
            {
                $text = new CobraRemoteText();
                $text->setId($remoteText->id);
                $text->setRemoteCollection($collection);
                $text->setTitle($remoteText->title);
                $text->setSource($remoteText->source);
                $em->persist($text);
            }
        }
        $em->flush();
        
        return $this;
    }

    /*protected function insertRemoteTexts()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $textsObjectList = ElexRemoteService::call('loadAllTexts', array());
        foreach($textsObjectList as $remoteText)
        {
            $text = new CobraRemoteText();
            $text->setId($remoteText->id);
            $text->setRemoteCollection($remoteText->id_collection);
            $text->setTitle($remoteText->title);
            $text->setSource($remoteText->source);
            $em->persist($text);
        }
        $em->flush();
        return $this;
    }*/
}
