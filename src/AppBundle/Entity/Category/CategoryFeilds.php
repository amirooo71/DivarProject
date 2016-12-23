<?php

namespace AppBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryFeilds
 *
 * @ORM\Table(name="category_category_feilds")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Category\CategoryFeildsRepository")
 */
class CategoryFeilds {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="childCategory",inversedBy="categoryFeilds")
     */
    private $childCategory;
    


 

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
     * @return CategoryFeilds
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
     * Set type
     *
     * @param string $type
     *
     * @return CategoryFeilds
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set childCategory
     *
     * @param \AppBundle\Entity\Category\childCategory $childCategory
     *
     * @return CategoryFeilds
     */
    public function setChildCategory(\AppBundle\Entity\Category\childCategory $childCategory = null)
    {
        $this->childCategory = $childCategory;

        return $this;
    }

    /**
     * Get childCategory
     *
     * @return \AppBundle\Entity\Category\childCategory
     */
    public function getChildCategory()
    {
        return $this->childCategory;
    }
}
