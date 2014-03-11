<?php

namespace Unamur\CobraBundle\Controller;

use Unamur\CobraBundle\Manager\CobraViewerManager;
use Unamur\CobraBundle\Entity\CobraViewer;
use Unamur\CobraBundle\Entity\CobraCollection;
use Unamur\CobraBundle\Entity\CobraText;
use Unamur\CobraBundle\Form\CobraConfigType;
use Unamur\CobraBundle\Lib\ElexRemoteService;

use Claroline\CoreBundle\Library\Resource\ResourceCollection;
use Claroline\CoreBundle\Library\Security\Utilities;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;

class CobraViewerController extends Controller
{
    private $cobraManager;
    private $eventDispatcher;
    private $formFactory;
    private $securityContext;
    private $translator;
    private $utils;
    private $session;

    /**
     * @DI\InjectParams({
     *     "cobraManager"        = @DI\Inject("unamur.cobra.manager.cobra_manager"),
     *     "eventDispatcher"     = @DI\Inject("event_dispatcher"),
     *     "formFactory"         = @DI\Inject("form.factory"),
     *     "securityContext"     = @DI\Inject("security.context"),
     *     "translator"          = @DI\Inject("translator"),
     *     "utils"               = @DI\Inject("claroline.security.utilities"),
     *     "session"             = @DI\Inject("session")
     * })
     */
    public function __construct(
        CobraViewerManager $cobraManager,
        FormFactoryInterface $formFactory,
        SecurityContextInterface $securityContext,
        EventDispatcherInterface $eventDispatcher,
        Translator $translator,
        Utilities $utils,
        Session $session
    )
    {
        $this->cobraManager = $cobraManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->utils = $utils;
        $this->session = $session;
    }


    /**
     * @EXT\Route(
     *      "/list/viewer/{cobraViewerId}",
     *      name = "unamur_cobra_collection_list"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "cobraViewer",
     *      class="UnamurCobraBundle:CobraViewer",
     *      options={"id" = "cobraViewerId", "strictId" = true}
     * )
     * @EXT\Template("UnamurCobraBundle::collectionList.html.twig")
     * @param CobraViewer $cobraViewer
     *
     * @return Response
     */
    public function collectionListAction($cobraViewer)
    {
        $resourceCollection = new ResourceCollection(array($cobraViewer->getResourceNode()));
        try {
            $this->checkAccess('EDIT', $cobraViewer);
            $registeredCollections = $this->cobraManager->getRegisteredCollectionsOfViewer($cobraViewer);
            $unregisteredCollections = $this->cobraManager->getUnregisteredCollectionsForViewer($cobraViewer);
        }
        catch(AccessDeniedException $e) {
            $this->checkAccess('OPEN', $cobraViewer);
            $collections = array('nocoucou', 'nogamin');
        }
        return array(
            '_resource' => $cobraViewer,
            'regCollections' => $registeredCollections,
            'unregCollections' => $unregisteredCollections,
            'resourceCollection' => $resourceCollection
        );
        /*test*/
    }

    /**
     * @EXT\Route(
     *      "/text/{cobraTextId}",
     *      name = "unamur_cobra_show_text"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "cobraText",
     *      class="UnamurCobraBundle:CobraText",
     *      options={"id" = "cobraTextId", "strictId" = true}
     * )
     * @EXT\Template("UnamurCobraBundle::text.html.twig")
     * @param CobraText $cobraText
     *
     * @return Response
     */
    public function showTextAction(CobraText $cobraText)
    {
        $cobraViewer = $cobraText->getCollection()->getCobraViewer();
        $this->checkAccess('OPEN', $cobraViewer);

        return array(
            '_resource' => $cobraViewer,
            'text' => $cobraText,
            'display' => $this->cobraManager->getTextDisplay($cobraText)
        );
    }

    /**
     * @EXT\Route(
     *      "/viewer/{cobraViewerId}/register/{cobraRemoteCollectionId}",
     *      name="unamur_cobra_register_collection",
     *      requirements={"cobraViewerId" = "\d+", "cobraRemoteCollectionId" = "\d+"})
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "cobraViewer",
     *      class="UnamurCobraBundle:CobraViewer",
     *      options={"id" = "cobraViewerId", "strictId" = true}
     * )
     * @EXT\Template()
     * @param CobraViewer $cobraViewer
     * @param int $cobraRemoteCollectionId
     *
     * @return Response
     */
    public function registerCollectionAction(CobraViewer $cobraViewer, $cobraRemoteCollectionId)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $collection = new CobraCollection();
        $collection->setCobraViewer($cobraViewer);
        $collection->setRemoteId($cobraRemoteCollectionId);
        $collection->setCreator($this->securityContext->getToken()->getUser());
        if( !$this->cobraManager->isAlreadyRegistered($collection))
        {
            $this->cobraManager->registerCollection($collection);
        }
        else
        {
            $this->session->getFlashBag()->add('success', 'already registered');
        }
        return $this->redirect($this->generateUrl('unamur_cobra_collection_list', array('cobraViewerId' => $cobraViewer->getId())));
    }

    /**
     * @EXT\Route(
     *     "/collection/{cobraCollectionId}/unregister",
     *     name = "unamur_cobra_unregister_collection",
     *     options={"expose"=true}
     * )
     * @EXT\ParamConverter(
     *      "cobraCollection",
     *      class="UnamurCobraBundle:CobraCollection",
     *      options={"id" = "cobraCollectionId", "strictId" = true}
     * )
     *
     * @param CobraCollection $cobraCollection
     *
     * @return Response
     */
    public function unregisterCollectionAction(CobraCollection $cobraCollection)
    {
        $resource = $cobraCollection->getCobraViewer();
        $this->checkAccess('EDIT', $resource);

        try
        {
            $this->cobraManager->unregisterCollection($cobraCollection);
            $this->session->getFlashBag()->add('success', $this->translator->trans('unamur_cobra_unregister_collection_success', array(), 'unamur_cobra'));
        }
        catch(\Exception $exception)
        {
            $this->session->getFlashBag()->add('error', $this->translator->trans('unamur_cobra_unregister_collection_error', array(), 'unamur_cobra'));
        }
        // change return statement to response (204) if handled by javascript
        //return new Response(204);
        return $this->redirect($this->generateUrl('unamur_cobra_collection_list', array('cobraViewerId' => $resource->getId())));
    }

    /**
     * @EXT\Route(
     *     "/collection/{cobraCollectionId}/changeVisibility",
     *     name = "unamur_cobra_change_collection_visibility",
     *     options={"expose"=true}
     * )
     *
     * @EXT\Method("POST")
     *
     * @EXT\ParamConverter(
     *      "cobraCollection",
     *      class="UnamurCobraBundle:CobraCollection",
     *      options={"id" = "cobraCollectionId", "strictId" = true}
     * )
     *
     * @param CobraCollection $cobraCollection
     * @return Response
     */
    public function changeVisibilityAction(CobraCollection $cobraCollection)
    {
        $resource = $cobraCollection->getCobraViewer();
        /*if (!$this->get('security.context')->isGranted('EDIT', $resource)) {
            throw new AccessDeniedException($resource->getErrorsForDisplay());
        }*/
        $this->checkAccess('EDIT', $resource);
        //$flashBag = $this->get('session')->getFlashBag();
        //$translator = $this->get('translator');
        $entityManager = $this->getDoctrine()->getManager();
        $cobraCollection->setVisible(!$cobraCollection->isVisible());
        $entityManager->flush();

        return new Response(204);
    }

    /**
     * @EXT\Route(
     *     "/collection/{cobraCollectionId}/move/{direction}",
     *     name = "unamur_cobra_move_collection",
     *     options={"expose"=true}
     * )
     *
     * @EXT\Method("POST")
     *
     * @EXT\ParamConverter(
     *      "cobraCollection",
     *      class="UnamurCobraBundle:CobraCollection",
     *      options={"id" = "cobraCollectionId", "strictId" = true}
     * )
     *
     * @param CobraCollection $cobraCollection
     * @param string $direction
     * @return Response
     */
    public function moveCobraCollection(CobraCollection $cobraCollection, $direction = 'up')
    {
        try
        {
            if('up' == $direction)
            {
                $this->cobraManager->moveUpCollection($cobraCollection);
            }
            elseif('down' == $direction)
            {
                $this->cobraManager->moveDownCollection($cobraCollection);
            }
            $this->getDoctrine()->getManager()->flush();
        }
        catch(\Exception $exception)
        {

        }
        return new Response(204);
    }

    /**
     * @EXT\Route("/viewer/configure/{cobraViewerId}/form", name="unamur_cobra_viewer_configure_form", requirements={"cobraViewerId" = "\d+"})
     * @EXT\ParamConverter("cobraViewer", class="UnamurCobraBundle:CobraViewer", options={"id" = "cobraViewerId"})
     * @EXT\Template("UnamurCobraBundle::configureViewer.html.twig")
     */
    public function configureViewerFormAction(CobraViewer $cobraViewer)
    {
        $this->checkAccess('EDIT', $cobraViewer);
        $registeredCollections = $this->cobraManager->getRegisteredCollectionsOfViewer($cobraViewer);
        $unregisteredCollections = $this->cobraManager->getUnregisteredCollectionsForViewer($cobraViewer);
$corpusArray = $cobraViewer->getCorpusDisplayOrder();
        $form = $this->formFactory->create(new CobraConfigType(), $cobraViewer);

        return array(
            'form' => $form->createView(),
            '_resource' => $cobraViewer,
            'regCollections' => $registeredCollections,
            'unregCollections' => array(),
            'corpus' => $corpusArray
            //'unregCollections' => $unregisteredCollections
        );
    }

    /**
     * @EXT\Route("/viewer/configure/{cobraViewerId}", name="unamur_cobra_viewer_configure", requirements={"cobraViewerId" = "\d+"})
     * @EXT\ParamConverter("cobraViewer", class="UnamurCobraBundle:CobraViewer", options={"id" = "cobraViewerId"})
     * @EXT\Template("UnamurCobraBundle::configureViewer.html.twig")
     */
    public function configureViewerAction(Request $request, CobraViewer $cobraViewer)
    {
        $this->checkAccess('EDIT', $cobraViewer);

        $form = $this->formFactory->create(new CobraConfigType(), $cobraViewer);

        $form->handleRequest($request);

        if ("POST" === $request->getMethod())
        {
            if ($form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                try
                {
                    $cobraViewer->getResourceNode()->setName($cobraViewer->getName());
                    $entityManager->flush();
                    $this->session->getFlashBag()->add('success', $this->translator->trans('unamur_cobra_viewer_configure_success', array(), 'unamur_cobra'));
                } catch (\Exception $exception) {
                    $this->session->getFlashBag()->add('error', $this->translator->trans('unamur_cobra_viewer_configure_error', array(), 'unamur_cobra'));
                }

                return $this->redirect($this->generateUrl('unamur_cobra_collection_list', array('cobraViewerId' => $cobraViewer->getId())));
            }
            else
            {
                $this->session->getFlashBag()->add('error', $this->translator->trans('unamur_cobra_viewer_configure_error_invalid', array(), 'unamur_cobra'));
                //return $this->redirect($this->generateUrl('unamur_cobra_collection_list', array('cobraViewerId' => $cobraViewer->getId())));
            }
        }
        else{
            $this->session->getFlashBag()->add('error', $this->translator->trans('unamur_cobra_viewer_configure_error_post', array(), 'unamur_cobra'));
            //return $this->redirect($this->generateUrl('unamur_cobra_collection_list', array('cobraViewerId' => $cobraViewer->getId())));
        }

        return array(
            '_resource'  => $cobraViewer,
            'form'       => $form->createView(),
        );
    }


    /**
     * Checks if the current user has the right to perform an action on a ResourceCollection.
     * Be careful, ResourceCollection may need some aditionnal parameters.
     *
     * - for CREATE: $collection->setAttributes(array('type' => $resourceType))
     *  where $resourceType is the name of the resource type.
     * - for MOVE / COPY $collection->setAttributes(array('parent' => $parent))
     *  where $parent is the new parent entity.
     *
     * @param string             $permission
     * @param ResourceCollection $collection
     *
     * @throws AccessDeniedException
     */
    private function checkAccess($permission, CobraViewer $resource)
    {
        $collection = new ResourceCollection(array($resource->getResourceNode()));

        if (!$this->securityContext->isGranted($permission, $collection)) {
            throw new AccessDeniedException($collection->getErrorsForDisplay());
        }
    }
}
