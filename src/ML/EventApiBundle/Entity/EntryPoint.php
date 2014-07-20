<?php

namespace ML\EventApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * The main entry point or homepage of the API.
 *
 * @Hydra\Expose()
 * @Hydra\Id(route = "entry_point")
 *
 * @author Markus Lanthaler <mail@markus-lanthaler.com>
 */
class EntryPoint
{
    /**
     * events
     *
     * The events collection
     *
     * @Hydra\Expose()
     * @Hydra\Route("event_collection_retrieve")
     *
     * @return ML\EventApiBundle\Entity\EventCollection
     */
    public function getEvents()
    {
        return array();
    }
}
