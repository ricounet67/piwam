<?php

class Cotisation extends BaseCotisation
{
    /**
     * Indicates the number of years of validity of the payment
     * 
     * @return  integer
     * @since   r1
     */
    public function getValidity()
    {
        return $this->getCotisationType()->getValide();
    }
}
