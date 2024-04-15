<?php

class Room
{
    private string $roomNumber;
    private string $type;
    private float $pricePerNight;

    /**
     * Room constructor.
     * @param string $roomNumber
     * @param string $type
     * @param float $pricePerNight
     */
    public function __construct(string $roomNumber, string $type, float $pricePerNight)
    {
        $this->roomNumber = $roomNumber;
        $this->type = $type;
        $this->pricePerNight = $pricePerNight;
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
