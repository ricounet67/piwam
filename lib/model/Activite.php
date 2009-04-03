<?php

class Activite extends BaseActivite
{
    /**
     * We display the label of the activity if we would like to display the
     * value of the object
     *
     * @return  string
     * @since   r5
     */
    public function __toString()
    {
        return $this->getLibelle();
    }
}
