<?php

class Compte extends BaseCompte
{
    /**
     * We display the reference of the account if we would like to
     * display it
     *
     * @return  string
     * @since   r5
     */
    public function __toString()
    {
        return $this->getReference();
    }
}
