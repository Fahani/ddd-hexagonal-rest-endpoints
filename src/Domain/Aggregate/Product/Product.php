<?php

declare(strict_types=1);

namespace App\Domain\Aggregate\Product;

use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use DateTime;

class Product
{
    private string $id;
    private string $name;
    private string $description;
    private string $link;
    private Availability $availability;
    private Price $price;
    /** @var Image[] */
    private array $image;
    /** @var Variation[] */
    private array $variations;
    private DateTime $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $link,
        Availability $availability,
        Price $price,
        array $image,
        array $variations,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->link = $link;
        $this->availability = $availability;
        $this->price = $price;
        $this->image = $image;
        $this->variations = $variations;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getAvailability(): Availability
    {
        return $this->availability;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return Image[]
     */
    public function getImage(): array
    {
        return $this->image;
    }

    /**
     * @return Variation[]
     */
    public function getVariations(): array
    {
        return $this->variations;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}