<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 09/10/2014
 * Time: 15:00
 */

namespace RumeauLibAppConfig\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AppConfig
 * @package RumeauLibAppConfig\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="app_config",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UniqueConfigKey", columns={"section_name","option_name"})}
 * )
 */
class AppConfig
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(nullable=false, name="option_name")
     */
    private $option;

    /**
     * @ORM\Column(nullable=true, name="section_name")
     */
    private $section;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    private $value;

    /**
     * @var bool
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isSerialized = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function getIsSerialized()
    {
        return $this->isSerialized;
    }

    /**
     * @param boolean $isSerialized
     */
    public function setIsSerialized($isSerialized)
    {
        $this->isSerialized = $isSerialized;
    }

    /**
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param string $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * @return null|string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param null|string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
