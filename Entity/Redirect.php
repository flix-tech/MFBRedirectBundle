<?php

namespace MFB\RedirectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Smurfy\DoctrineEnumBundle\Validator as EnumAssert;
use MFB\RedirectBundle\Entity\Types\RedirectStatusType;

/**
 * MFB\RedirectBundle\Entity\Block
 *
 * @ORM\Table(name="redirects")
 * @ORM\Entity(repositoryClass="MFB\RedirectBundle\Entity\Repository\RedirectRepository")
 */
class Redirect
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var string $target
     *
     * @ORM\Column(name="target", type="string", length=255)
     */
    protected $target;

    /**
     * @ORM\Column(name="status", type="RedirectStatusType", nullable=false)
     * @EnumAssert\DoctrineEnumType(
     *    entity="MFB\RedirectBundle\Entity\Types\RedirectStatusType"
     * )
     *
     * @var string $status
     */
    protected $status = RedirectStatusType::DISABLED;

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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function __toString()
    {
        return $this->slug;
    }

    /**
     * Set target
     *
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}