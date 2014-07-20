<?php

namespace ML\EventApiBundle\Entity;

use ML\HydraBundle\Entity\Collection;
use ML\HydraBundle\Mapping as Hydra;

/**
 * A collection of events
 *
 * @Hydra\Expose()
 * @Hydra\Id("event_collection_retrieve")
 * @Hydra\Operations( {
 *     "event_create"
 * } )
 *
 * @author Markus Lanthaler <mail@markus-lanthaler.com>
 */
class EventCollection extends Collection
{
    /**
     * members
     *
     * The events
     *
     * @var array<ML\EventApiBundle\Entity\Event>
     *
     * @Hydra\Expose(iri="http://www.w3.org/ns/hydra/core#member")
     */
    private $members;

    /**
     * Constructor
     *
     * @var string $id      The IRI identifying this Collection.
     * @var array  $members The members.
     */
    public function __construct($members)
    {
        $this->setMembers($members);
    }
}
