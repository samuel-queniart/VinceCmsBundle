<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity provides features to manage contents
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class Content
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Article
     */
    private $article;

    /**
     * @var Area
     */
    private $area;

    /**
     * Get contents
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @return string
     */
    public function __toString()
    {
        return $this->getContents();
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
     * Set contents
     *
     * @param string $contents
     * @return Content
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Content
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
     * @return Content
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

    /**
     * Set article
     *
     * @param Article $article
     * @return Content
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set area
     *
     * @param Area $area
     * @return Content
     */
    public function setArea(Area $area = null)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }
}
