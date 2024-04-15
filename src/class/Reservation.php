<?php

class Reservation
{
    private User $user;
    private Room $room;
    private $reservationDebut;
    private $reservationFin;
    private $nombreDePersonnes;

    /**
     * Reservation constructor.
     * @param User $user
     * @param Room $room
     * @param $reservationDebut
     * @param $reservationFin
     * @param $nombreDePersonnes
     */
    public function __construct(User $user, Room $room, $reservationDebut, $reservationFin, $nombreDePersonnes)
    {
        $this->user = $user;
        $this->room = $room;
        $this->reservationDebut = $reservationDebut;
        $this->reservationFin = $reservationFin;
        $this->nombreDePersonnes = $nombreDePersonnes;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    /**
     * @return mixed
     */
    public function getReservationDebut()
    {
        return $this->reservationDebut;
    }

    /**
     * @param mixed $reservationDebut
     */
    public function setReservationDebut($reservationDebut): void
    {
        $this->reservationDebut = $reservationDebut;
    }

    /**
     * @return mixed
     */
    public function getReservationFin()
    {
        return $this->reservationFin;
    }

    /**
     * @param mixed $reservationFin
     */
    public function setReservationFin($reservationFin): void
    {
        $this->reservationFin = $reservationFin;
    }

    /**
     * @return mixed
     */
    public function getNombreDePersonnes()
    {
        return $this->nombreDePersonnes;
    }

    /**
     * @param mixed $nombreDePersonnes
     */
    public function setNombreDePersonnes($nombreDePersonnes): void
    {
        $this->nombreDePersonnes = $nombreDePersonnes;
    }
}
