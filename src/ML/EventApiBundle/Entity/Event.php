<?php

namespace ML\EventApiBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Hydra\Expose(iri="http://schema.org/Event")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The event's name
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Hydra\Expose(iri="http://schema.org/name", required=true)
     */
    private $name;

    /**
     * Description of the event
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     *
     * @Hydra\Expose(iri="http://schema.org/description", required=true)
     */
    private $description;

    /**
     * The start date and time of the event in ISO 8601 date format
     *
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="startDate", type="datetime")
     *
     * @Hydra\Expose(iri="http://schema.org/startDate", required=true)
     */
    private $startDate;

    /**
     * The end date and time of the event in ISO 8601 date format
     *
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="endDate", type="datetime")
     *
     * @Hydra\Expose(iri="http://schema.org/endDate", required=true)
     */
    private $endDate;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
