<?php
/**
 * Embeds and offers some useful string operations
 *
 * @author 	Adrien Mogenet
 * @since	r39
 */
class StringTools
{
    /**
     * Convert a string as alpha numeric string.
     * Accents and non alphanumeric characters are deleted
     *
     * @param 	string		$text
     * @param 	string 		$from_enc
     * @return 	string :	clean result
     * @since	r39
     * @see 	http://www.3gk-software.com/Traitement-des-chaines-de-caracteres/PHP-Supprimer-les-accents-et-les-caracteres-speciaux.html
     */
    public static function to7bit($text, $from_enc = 'UTF-8')
    {
        $text = mb_convert_encoding($text, 'HTML-ENTITIES', $from_enc);
        $text = preg_replace(	array('/ß/','/&(..)lig;/', '/&([aouAOU])uml;/','/&(.)[^;]*;/'),
        array('ss',"$1","$1".'e',"$1"),
        $text);

        $result = eregi_replace("[^a-z0-9 ]",'',$text);

        return $result;
    }
}
?>