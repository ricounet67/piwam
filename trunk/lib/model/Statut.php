<?php

class Statut extends BaseStatut
{
    public function __toString()
    {
        return $this->nom;
    }
}
