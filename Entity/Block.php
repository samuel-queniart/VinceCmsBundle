<?php

namespace Vince\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Block
 */
abstract class Block
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $contents;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * @var \DateTime
     */
    protected $endedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __toString()
    {
        return $this->getContents();
    }

    /**
     * Check if publication is correct
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     *
     * @param ExecutionContext $context
     */
    public function isPublicationValid(ExecutionContext $context)
    {
        // No start publication date specified for the end publication date
        if (!$this->getStartedAt() && $this->getEndedAt()) {
            $context->addViolationAt('startedAt', 'Start publication date is required when setting end publication date.');
        }
        // Start publication date is equal or later than end publication date
        if ($this->getEndedAt() && $this->getStartedAt() && $this->getStartedAt()->getTimestamp() >= $this->getEndedAt()->getTimestamp()) {
            $context->addViolationAt('endedAt', 'End publication date must be later than start publication date.');
        }
    }

    /**
     * Check if Article is published
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return bool
     */
    public function isPublished()
    {
        return $this->getStartedAt()
            && $this->getStartedAt()->getTimestamp() <= time()
            && (!$this->getEndedAt() || $this->getEndedAt()->getTimestamp() >= time());
    }

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
     *
     * @return Block
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
     * Set contents
     *
     * @param string $contents
     *
     * @return Block
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get contents
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     *
     * @return Block
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set endedAt
     *
     * @param \DateTime $endedAt
     *
     * @return Block
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get endedAt
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Block
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Block
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}