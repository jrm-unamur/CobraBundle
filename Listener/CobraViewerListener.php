<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 12/02/14
 * Time: 14:26
 */

namespace Unamur\CobraBundle\Listener;

use Unamur\CobraBundle\Entity\CobraViewer;
use Unamur\CobraBundle\Form\CobraViewerType;
use Unamur\CobraBundle\Form\CobraConfigType;
use Claroline\CoreBundle\Event\CreateFormResourceEvent;
use Claroline\CoreBundle\Event\CreateResourceEvent;
use Claroline\CoreBundle\Event\DeleteResourceEvent;
use Claroline\CoreBundle\Event\OpenResourceEvent;
use Claroline\CoreBundle\Event\CustomActionResourceEvent;
//use Claroline\CoreBundle\Form\Factory\FormFactory;
use Claroline\CoreBundle\Manager\ResourceManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Claroline\CoreBundle\Listener\NoHttpRequestException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormFactory;
use JMS\DiExtraBundle\Annotation as DI;


/**
 * @DI\Service()
 */
class CobraViewerListener extends ContainerAware
{
    private $formFactory;
    private $resourceManager;
    private $request;
    private $router;
    private $templating;

    /**
     * @DI\InjectParams({
     *      "formFactory" = @DI\Inject("form.factory"),
     *      "requestStack" = @DI\Inject("request_stack"),
     *      "resourceManager"    = @DI\Inject("claroline.manager.resource_manager"),
     *      "router" = @DI\Inject("router"),
     *      "templating" = @DI\Inject("templating")
     * })
     */
    public function __construct(
        FormFactory $formFactory,
        RequestStack $requestStack,
        ResourceManager $resourceManager,
        TwigEngine $templating,
        UrlGeneratorInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->resourceManager = $resourceManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
        $this->templating = $templating;
    }

    /**
     * @DI\Observe("create_form_unamur_cobra_viewer")
     *
     * @param CreateFormResourceEvent $event
     */
    public function onCreateForm(CreateFormResourceEvent $event)
    {
        $form = $this->formFactory->create(
            new CobraViewerType(),
            new CobraViewer()
        );
        $content = $this->templating->render(
            'UnamurCobraBundle::viewerCreate.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'unamur_cobra_viewer'
            )
        );
        $event->setResponseContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("create_unamur_cobra_viewer")
     *
     * @param CreateResourceEvent $event
     * @throws \Claroline\CoreBundle\Listener\NoHttpRequestException
     */
    public function onCreate(CreateResourceEvent $event)
    {
        if (!$this->request) {
            throw new NoHttpRequestException();
        }

        $form = $this->formFactory->create(
            new CobraViewerType(),
            new CobraViewer()
        );
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $cobraViewer = $form->getData();
            $cobraViewer->initCorpusList();
            $event->setResources(array($cobraViewer));
            $event->stopPropagation();

            return;
        }

        /*$content = $this->templating->render(
            'ClarolineCoreBundle:Resource:createForm.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'unamur_cobra_viewer'
            )
        );*/
        $content = $this->templating->render(
            'UnamurCobraBundle::viewerCreate.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'unamur_cobra_viewer'
            )
        );
        $event->setErrorFormContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_unamur_cobra_viewer")
     *
     * @param OpenResourceEvent $event
     */
    public function onOpen(OpenResourceEvent $event)
    {
        $route = $this->router->generate(
            'unamur_cobra_collection_list',
            array('cobraViewerId' => $event->getResource()->getId())
        );
        $event->setResponse(new RedirectResponse($route));
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("delete_unamur_cobra_viewer")
     *
     * @param DeleteResourceEvent $event
     */
    public function onDelete(DeleteResourceEvent $event)
    {
        //$this->resourceManager->delete($event->getResource());
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("configure_unamur_cobra_viewer")
     * @param CustomActionResourceEvent $event
     */
    public function onConfigure(CustomActionResourceEvent $event)
    {
        $route = $this->router
            ->generate(
                'unamur_cobra_viewer_configure_form',
                array('cobraViewerId' => $event->getResource()->getId())
            );
        $event->setResponse(new RedirectResponse($route));
        $event->stopPropagation();
    }
} 