<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 12/02/14
 * Time: 14:26
 */

namespace JrmUnamur\CobraBundle\Listener;

use JrmUnamur\CobraBundle\Entity\CobraViewer;
use Claroline\CoreBundle\Event\CreateFormResourceEvent;
use Claroline\CoreBundle\Event\CreateResourceEvent;
use Claroline\CoreBundle\Event\DeleteResourceEvent;
use Claroline\CoreBundle\Event\OpenResourceEvent;
use Claroline\CoreBundle\Form\Factory\FormFactory;
use Claroline\CoreBundle\Listener\NoHttpRequestException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use JMS\DiExtraBundle\Annotation as DI;


/*
 * @DI\Service()
 */
class CobraViewerListener
{
    private $formFactory;
    private $request;
    private $router;
    private $templating;

    /**
     * @DI\InjectParams({
     *      "formFactory" = @DI\Inject("claroline.form.factory"),
     *      "requestStack" = @DI\Inject("request_stack"),
     *      "router" = @DI\Inject("router"),
     *      "templating" = @DI\Inject("templating")
     * })
     */
    public function __construct(
        FormFactory $formFactory,
        RequestStack $requestStack,
        TwigEngine $templating,
        UrlGeneratorInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
        $this->templating = $templating;
    }

    /**
     * @DI\Observe("unamur_cobra_viewer_create_form")
     *
     * @param CreateFormResourceEvent $event
     */
    public function onCreateForm(CreateFormResourceEvent $event)
    {
        $form = $this->formFactory->create(
            FormFactory::TYPE_RESOURCE_RENAME,
            array(),
            new CobraViewer()
        );
        $content = $this->templating->render(
            'ClarolineCoreBundle:Resource:createForm.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'unamur_cobra_viewer'
            )
        );
        $event->setResponseContent($content);
        $event->stopPropagation();
    }

} 