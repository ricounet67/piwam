<?php

class Statut extends BaseStatut
{
    /**
     * Returns the name of the statut as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Get the number of members who belong to the current Statut
     * Note: this also count disabled users
     *
     * @return	integer
     */
    public function countMembers()
    {
		$c = new Criteria();
		$c->add(StatutPeer::ID, $this->getId());

		return MembrePeer::doCountJoinStatut($c);
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
}
