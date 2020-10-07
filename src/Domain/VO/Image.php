<?php

declare(strict_types=1);


namespace App\Domain\VO;


class Image
{
    private string $url;
    private string $alt;

    public function __construct(string $url, string $alt)
    {
        $this->url = $url;
        $this->alt = $alt;
    }


    public function getUrl(): string
    {
        return $this->url;
    }


    public function getAlt(): string
    {
        return $this->alt;
    }
}