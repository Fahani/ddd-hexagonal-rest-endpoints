<?php

declare(strict_types=1);


namespace App\Domain\VO;

use DateTime;

class Variation
{
    private string $id;
    private string $color;
    private string $material;
    private DateTime $updatedAt;

    public function __construct(string $id, string $color, string $material, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->color = $color;
        $this->material = $material;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getMaterial(): string
    {
        return $this->material;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}