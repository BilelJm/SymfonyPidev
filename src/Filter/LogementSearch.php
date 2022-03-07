<?php

namespace App\Filter;

class LogementSearch
{
    /**
     * @var int | null
     */
    private $id;

    /**
     * @var string | null
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return LogementSearch
     */
    public function setId(?int $id): LogementSearch
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return LogementSearch
     */
    public function setName(?string $name): LogementSearch
    {
        $this->name = $name;
        return $this;
    }


}