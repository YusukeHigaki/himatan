<?php

namespace Yusuke\HimatanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="post_user_id_fk", columns={"user_id"}), @ORM\Index(name="post_area_id1_fk", columns={"area_id1"}), @ORM\Index(name="post_area_id2_fk", columns={"area_id2"}), @ORM\Index(name="post_area_id3_fk", columns={"area_id3"}), @ORM\Index(name="post_created_at_idx", columns={"created_at"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     *
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id1", type="integer", nullable=false)
     * @Assert\NotBlank(groups={"setPost"})
     * @Assert\Type(type="integer",message="The value {{ value }} is not a valid {{ type }}.",groups={"setPost"})
     * @Assert\Length(min="1",max="11",groups={"setPost"})
     *
     */
    private $areaId1;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id2", type="integer", nullable=true)
     * @Assert\Type(type="integer",message="The value {{ value }} is not a valid {{ type }}.",groups={"setPost"})
     * @Assert\Length(min="1",max="11",groups={"setPost"})
     */
    private $areaId2;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id3", type="integer", nullable=true)
     * @Assert\Type(type="integer",message="The value {{ value }} is not a valid {{ type }}.",groups={"setPost"})
     * @Assert\Length(min="1",max="11",groups={"setPost"})
     */
    private $areaId3;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=100, nullable=false)
     *
     * @Assert\NotBlank(groups={"setPost"})
     * @Assert\Type(type="string",message="The value {{ value }} is not a valid {{ type }}.",groups={"setPost"})
     * @Assert\Length(min="5",max="100",groups={"setPost"})
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delete_flag", type="boolean", nullable=false)
     */
    private $deleteFlag = '0';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     *
     * @Assert\NotBlank(groups={"setPost"})
     */
    private $user;



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
     * Set areaId1
     *
     * @param integer $areaId1
     * @return Post
     */
    public function setAreaId1($areaId1)
    {
        $this->areaId1 = $areaId1;

        return $this;
    }

    /**
     * Get areaId1
     *
     * @return integer 
     */
    public function getAreaId1()
    {
        return $this->areaId1;
    }

    /**
     * Set areaId2
     *
     * @param integer $areaId2
     * @return Post
     */
    public function setAreaId2($areaId2)
    {
        $this->areaId2 = $areaId2;

        return $this;
    }

    /**
     * Get areaId2
     *
     * @return integer 
     */
    public function getAreaId2()
    {
        return $this->areaId2;
    }

    /**
     * Set areaId3
     *
     * @param integer $areaId3
     * @return Post
     */
    public function setAreaId3($areaId3)
    {
        $this->areaId3 = $areaId3;

        return $this;
    }

    /**
     * Get areaId3
     *
     * @return integer 
     */
    public function getAreaId3()
    {
        return $this->areaId3;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
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
     * @return Post
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
     * Set deleteFlag
     *
     * @param boolean $deleteFlag
     * @return Post
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }

    /**
     * Get deleteFlag
     *
     * @return boolean 
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }

    /**
     * Set user
     *
     * @param \Yusuke\HimatanBundle\Entity\User $user
     * @return Post
     */
    public function setUser(\Yusuke\HimatanBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Yusuke\HimatanBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
