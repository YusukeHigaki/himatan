<?php

namespace Yusuke\HimatanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File;


/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="user_area_id_fk", columns={"area_id"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     * @Assert\NotBlank(groups={"updateUserApi"})
     * @Assert\Type(type="string",message="The value {{ value }} is not a valid {{ type }}.",groups={"updateUserApi"})
     * @Assert\Length(min="1",max="50",groups={"updateUserApi"})
     */
    private $name = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="sex", type="integer", nullable=true)
     * @Assert\NotBlank(groups={"updateUserApi"})
     * @Assert\Type(type="int",message="The value {{ value }} is not a valid {{ type }}.",groups={"updateUserApi"})
     * @Assert\Length(min="1",max="1",groups={"updateUserApi"})
     */
    private $sex;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     * @Assert\NotBlank(groups={"updateUserApi"})
     * @Assert\Type(type="int",message="The value {{ value }} is not a valid {{ type }}.",groups={"updateUserApi"})
     * @Assert\Length(min="1",max="2",groups={"updateUserApi"})
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id", type="integer", nullable=true)
     * @Assert\NotBlank(groups={"updateUserApi"})
     * @Assert\Type(type="int",message="The value {{ value }} is not a valid {{ type }}.",groups={"updateUserApi"})
     */
    private $areaId;

    /**
     * @var string
     *
     * @ORM\Column(name="pic1", type="string", length=255, nullable=true)

     */
    private $pic1;

    /**
     * @var string
     *
     * @ORM\Column(name="pic2", type="string", length=255, nullable=true)

     */
    private $pic2;

    /**
     * @var string
     *
     * @ORM\Column(name="pic3", type="string", length=255, nullable=true)

     */
    private $pic3;

    /**
     * @var string
     *
     * @ORM\Column(name="pic4", type="string", length=255, nullable=true)

     */
    private $pic4;


    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="string", length=100, nullable=true)
     * @Assert\NotBlank(groups={"updateUserApi"})
     * @Assert\Type(type="string",message="The value {{ value }} is not a valid {{ type }}.",groups={"updateUserApi"})
     * @Assert\Length(min="1",max="1000",groups={"updateUserApi"})
     */
    private $introduction = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="device", type="integer", nullable=false)
     * @Assert\NotBlank(groups={"setUserApi"})
     * @Assert\Type(type="integer",groups={"setUserApi"})
     */
    private $device;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     * @Assert\NotBlank(groups={"setUserApi"})
     * @Assert\Type(type="integer",groups={"setUserApi"})
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"setUserApi","updateTokenApi"})
     * @Assert\Type(type="string",groups={"setUserApi","updateTokenApi"})
     */
    private $token;

    /**
     * @var integer
     *
     * @ORM\Column(name="cnt_heart", type="integer", nullable=true)
     */
    private $cntHeart = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="cnt_report", type="integer", nullable=true)
     */
    private $cntReport = '0';

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

    private $file;

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
     * @return User
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
     * Set sex
     *
     * @param boolean $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return boolean 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set age
     *
     * @param boolean $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return boolean 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set areaId
     *
     * @param integer $areaId
     * @return User
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId
     *
     * @return integer 
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set pic1
     *
     * @param string $pic1
     * @return User
     */
    public function setPic1($pic1)
    {
        $this->pic1 = $pic1;

        return $this;
    }

    /**
     * Get pic1
     *
     * @return string 
     */
    public function getPic1()
    {
        return $this->pic1;
    }

    /**
     * Set pic2
     *
     * @param string $pic2
     * @return User
     */
    public function setPic2($pic2)
    {
        $this->pic2 = $pic2;

        return $this;
    }

    /**
     * Get pic2
     *
     * @return string
     */
    public function getPic2()
    {
        return $this->pic2;
    }

    /**
     * Set pic3
     *
     * @param string $pic3
     * @return User
     */
    public function setPic3($pic3)
    {
        $this->pic3 = $pic3;

        return $this;
    }

    /**
     * Get pic3
     *
     * @return string
     */
    public function getPic3()
    {
        return $this->pic3;
    }

    /**
     * Set pic4
     *
     * @param string $pic4
     * @return User
     */
    public function setPic4($pic4)
    {
        $this->pic4 = $pic4;

        return $this;
    }


    /**
     * Get pic4
     *
     * @return string
     */
    public function getPic4()
    {
        return $this->pic4;
    }


    /**
     * Set introduction
     *
     * @param string $introduction
     * @return User
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set device
     *
     * @param boolean $device
     * @return User
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return boolean 
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return User
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set cntHeart
     *
     * @param integer $cntHeart
     * @return User
     */
    public function setCntHeart($cntHeart)
    {
        $this->cntHeart = $cntHeart;

        return $this;
    }

    /**
     * Get cntHeart
     *
     * @return integer 
     */
    public function getCntHeart()
    {
        return $this->cntHeart;
    }

    /**
     * Set cntReport
     *
     * @param integer $cntReport
     * @return User
     */
    public function setCntReport($cntReport)
    {
        $this->cntReport = $cntReport;

        return $this;
    }

    /**
     * Get cntReport
     *
     * @return integer 
     */
    public function getCntReport()
    {
        return $this->cntReport;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * @return User
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }


}
