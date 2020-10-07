<?php

declare(strict_types=1);

namespace App\Domain\Aggregate\Ads;

class Advertisement
{
    private string $id;
    private string $name;
    private string $link;
    /** @var string[]  */
    private array $images;
    private string $discount;
    private string $message;
    /** @var string[]  */
    private array $colors;
    /** @var string[]  */
    private array $materials;


    public function __construct(
        string $id,
        string $name,
        string $link,
        array $images,
        string $discount,
        string $message,
        array $colors,
        array $materials
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
        $this->images = $images;
        $this->discount = $discount;
        $this->message = $message;
        $this->colors = $colors;
        $this->materials = $materials;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getDiscount(): string
{
        return $this->discount;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string[]
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return string[]
     */
    public function getMaterials(): array
    {
        return $this->materials;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}