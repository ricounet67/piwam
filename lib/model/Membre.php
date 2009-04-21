<?php

class Membre extends BaseMembre
{
    /**
     * Convert the object to a displayable string
     * 
     * @return  string
     * @since   r1
     */
    public function __toString()
    {
        return mb_convert_case($this->getPrenom() . ' ' . $this->getNom(), MB_CASE_TITLE);
    }
    
    
    /**
     * Returns a boolean showing if the member has to pay or not
     *
     * @return  boolean
     * @since   r1
     */
    public function isAjourCotisation()
    {
        if ($this->getExempteCotisation()) {
            return true;
        }
        else
        {
            $today = date('Y').date('n').date('d');
            $lastPayment = CotisationPeer::getDerniereDuMembre($this->getId());
            if ($lastPayment)
            {
                $dateVersement  = explode('-', $lastPayment->getDate());
                $moisVersement  = $dateVersement['1'] + 0;
                $anneExpire     = $dateVersement['0'] + $lastPayment->getValidity();
                $dateFin        = $anneExpire . $moisVersement . $dateVersement['2'];
                
                return ($dateFin >= $today);
            }
            else {
                return false;
            }
        }
    }
    
    
    /**
     * Disable the account of the member
     */
    public function disable()
    {
        $this->setActif(false);
        $this->save();
    }
    
    
    /**
     * Override the delete methods. We have to not be able to delete
     *
     */
    public function delete(PropelPDO $con = null)
    {
        $this->disable();
    }
    
    
    /**
     * Get the whole address of the Membre (street, city, zipcode...)
     * This is address may be used for Google Map localization
     * 
     * @return 	string
     * @since	r17
     */
    public function getCompleteAddress()
    {
    	return $this->getRue() . ', ' . $this->getCp() . ' ' . $this->getVille();
    }
}
