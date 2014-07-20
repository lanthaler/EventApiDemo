<?php

namespace ML\EventApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use ML\HydraBundle\JsonLdResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\EventApiBundle\Entity\Event;
use ML\EventApiBundle\Entity\EventCollection;

/**
 * Event controller
 *
 * @Route("/events")
 */
class EventController extends HydraController
{
    /**
     * Retrieves all Event entities
     *
     * @Route("/", name="event_collection_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\EventApiBundle\Entity\EventCollection
     */
    public function collectionGetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MLEventApiBundle:Event')->findAll();

        return new EventCollection($entities);
    }

    /**
     * Creates a new Event entity
     *
     * @Route("/", name="event_create")
     * @Method("POST")
     *
     * @Hydra\Operation(
     *   type = "http://schema.org/AddAction",
     *   expect = "ML\EventApiBundle\Entity\Event",
     *   status_codes = {
     *     "201" = "If the Event entity was created successfully."
     * })
     *
     * @return ML\EventApiBundle\Entity\Event
     */
    public function collectionPostAction(Request $request)
    {
        $entity = $this->deserialize($request->getContent(), 'ML\EventApiBundle\Entity\Event');

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $iri = $this->generateUrl('event_retrieve', array('id' => $entity->getId()), true);

        $response = new JsonLdResponse(
            $this->serialize($entity),
            201,
            array('Location' => $iri, 'Content-Location' => $iri)
        );

        return $response;
    }

    /**
     * Retrieves a Event entity
     *
     * @Route("/{id}", name="event_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\EventApiBundle\Entity\Event
     */
    public function getAction(Event $entity)
    {
        return $entity;
    }

    /**
     * Replaces an existing Event entity
     *
     * @Route("/{id}", name="event_replace")
     * @Method("PUT")
     *
     * @Hydra\Operation(
     *   type = "http://schema.org/UpdateAction",
     *   expect = "ML\EventApiBundle\Entity\Event",
     *   status_codes = {
     *     "404" = "If the Event entity wasn't found."
     *   }
     * )
     *
     * @return ML\EventApiBundle\Entity\Event
     */
    public function putAction(Request $request, Event $entity)
    {
        $entity = $this->deserialize($request->getContent(), $entity);

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $entity;
    }

    /**
     * Deletes a Event entity
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     *
     * @Hydra\Operation(
     *   type = "http://schema.org/DeleteAction"
     * )
     *
     * @return void
     */
    public function deleteAction(Request $request, Event $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();
    }
}
