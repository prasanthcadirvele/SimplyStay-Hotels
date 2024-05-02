<?php

class Room
{
    private int $id;
    private string $roomNumber;
    private string $type;
    private float $pricePerNight;

    private string $description;

    private string $thumbnailUrl;

    /**
     * Room constructor.
     * @param string $roomNumber
     * @param string $type
     * @param float $pricePerNight
     */
    public function __construct(string $roomNumber, string $type, float $pricePerNight, string $description, string $thumbnailUrl)
    {
        $this->roomNumber = $roomNumber;
        $this->type = $type;
        $this->pricePerNight = $pricePerNight;
        $this->description = $description;
        $this->thumbnailUrl = $thumbnailUrl;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getThumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }

    public function setThumbnailUrl(string $thumbnailUrl): void
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRoomNumber(): string
    {
        return $this->roomNumber;
    }

    /**
     * @param string $roomNumber
     */
    public function setRoomNumber(string $roomNumber): void
    {
        $this->roomNumber = $roomNumber;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getPricePerNight(): float
    {
        return $this->pricePerNight;
    }

    /**
     * @param float $pricePerNight
     */
    public function setPricePerNight(float $pricePerNight): void
    {
        $this->pricePerNight = $pricePerNight;
    }
}
