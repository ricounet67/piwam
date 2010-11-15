<?php
/**
 * Build a swift mailer object according to the configuration
 *
 * @author  Adrien Mogenet
 * @since   r154
 */
class MailerFactory
{
  /**
   * Build a swift mailer object according to the configuration.
   * The user is able to select the method he prefers to use
   * for sending emails. By default we use the mail() php function
   *
   * @param   integer                 $associationId
   * @param   sfUser                  $sfUser
   * @return  Swift_Mailer
   */
  public static function get($associationId, $sfUser = null)
  {
    switch (Configurator::get('method', $associationId, 'mail'))
    {
      case 'gmail': // yes this is just a special case for smtp ;-)
        $methodObject = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'tls');
        $methodObject->setUsername(Configurator::get('gmail_username', $associationId));
        $methodObject->setPassword(Configurator::get('gmail_password', $associationId));

        if (!extension_loaded('openssl') && $sfUser)
        {
          $sfUser->setFlash('error', 'Le module "openssl" n\'est pas activé. Veuillez l\'activer ou changer la méthode d\'envoi d\' e-mails');
        }
        break;

      case 'smtp':
        $smtpServer = Configurator::get('smtp_server', $associationId);
        $smtpPort = null;
        $smtpEncryption = null;
        $smtpUsername = Configurator::get('smtp_username', $associationId);
        $smtpPassword = Configurator::get('smtp_password', $associationId);
        $methodObject = Swift_SmtpTransport::newInstance($smtpServer, $smtpPort, $smtpEncryption);
        $methodObject->setUsername($smtpUsername);
        $methodObject->setPassword($smtpPassword);
        break;

      case 'sendmail':
        $sendmailPath = Configurator::get('sendmail_path', $associationId, '/usr/bin/sendmail');
        $methodObject = Swift_SendmailTransport::newInstance($sendmailPath . ' -bs');
        break;

      case 'mail':
        $methodObject = new Swift_MailTransport();
        break;

      default:
        $methodObject = new Swift_MailTransport();
        break;
    }

    return Swift_Mailer::newInstance($methodObject);
  }
  /**
   * Get mail template from database and send it to member in argument, use standard variables values and the
   * additionnal variable values provide in argument
   * @param   integer $sender_id the current user connected logged as email sender, can be null if email from task
   * @param   Member $toMember recipient member
   * @param   string $mailTemplateKey the key of template in database
   * @param   array $variableValues array('varName' => varValue) added to standard variables,
   * if varValue is instance of Member the varName is used as prefix and all member variables are generated,
   * if varValue is instance of Association the varName is used as prefix and all association variables are generated.
   * @return boolean true if mail has been sent with success, false otherwise
   */
  public static function loadTemplateAndSend($sender_id, Member $toMember, $mailTemplateKey, $variableValues = array())
  {
    $associationId = $toMember->getAssociationId();
    $mailer = MailerFactory::get($associationId);

    $from_email = Configurator::get('address', $associationId, 'no-response@yourasso.org');
    $assoName = $toMember->getAssociation()->getName();
    	
    $template = MailTemplateTable::getTemplateByKeyAndAssociationId($mailTemplateKey, $associationId);
    if($template == null)
    {
      sfContext::getInstance()->getLogger()->warning("The template mail with key "+ $mailTemplateKey+" hasn't found in database !");
      return false;
    }
    // member without email we log
    if(!$toMember->hasEmail())
    {
      sfContext::getInstance()->getLogger()->info("Member ".$toMember->getName()." without email, we don't send email ".$mailTemplateKey." !");
      return false;
    }
    $subject = sprintf('[%s] %s',$assoName,$template->getSubject());
    $message = Swift_Message::newInstance($subject,$template->getContent(),'text/html');
    $message->setFrom(array($from_email),$assoName);

    $message->addTo($toMember->getEmail());//,$toMember->getLastname()." ".$toMember->getFirstname());

    $varValues = self::_createStandardVariables($toMember);
    // add variables in argument and standard variables
    foreach ($variableValues as $key => $value  )
    {
      if($value instanceof Member)
      {
        $varValues = array_merge($varValues,self::getMemberVariables($value,$key));
      }
      else if($value instanceof Association)
      {
        $varValues = array_merge($varValues,self::getAssociationVariables($value,$key));
      }
      else{
        // TODO: avoid erase variable already exists
        $varValues[self::escapeVariable($key)] = $value;
      }
    }

    // specify replacements for recipient email
    $replacements = array(
      $toMember->getEmail() => $varValues
    );
    	
    //Load the plugin with these replacements
    $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
    // FUNC: batchSend if multiple recipients
    $mailer->send($message);
    return true;
  }

  public static function escapeVariable($varName,$prefix = null)
  {
    if($prefix != null)
    {
      return sprintf("{%s.%s}",$prefix,$varName);
    }
    else{
      return sprintf("{%s}",$varName);
    }
  }
  /**
   * Create default variables available for a Member
   * @param Member $member the member to obtain variables values
   * @param string $prefix prefix used to generate variable name
   */
  public static function getMemberVariables(Member $member,$prefix = 'member')
  {
    $email_link = "";
    if($member->hasEmail())
    {
      $email_link = '<a href="mailto:' . $member->getEmail() . '">' . $member->getEmail() . '</a>';
    }
    else{
      $email_link = "(Pas d'email)";
    }
    return array(
      self::escapeVariable('id',$prefix) => $member->getId(),
      self::escapeVariable('lastname',$prefix) => $member->getLastname(),
      self::escapeVariable('firstname',$prefix) => $member->getFirstname(),
      self::escapeVariable('name',$prefix) => $member->getFirstname().' '.$member->getLastname(),
      self::escapeVariable('username',$prefix) => $member->getUsername(),
      self::escapeVariable('email_link',$prefix) => $email_link,
      self::escapeVariable('email',$prefix) => $member->getEmail(),
      self::escapeVariable('city',$prefix) => $member->getCity(),
    //	self::escapeVariable('phonehome',$prefix) => format_phonenumber($member->getPhoneHome()),
    //	self::escapeVariable('phonemobile',$prefix) => format_phonenumber($member->getPhoneMobile()),
    );
  }
  /**
   * Create default variables for association
   * @param Association $asso
   * @param string $prefix
   */
  public static function getAssociationVariables(Association $asso,$prefix = 'association')
  {
    $website = $asso->getWebsite();
    return array(
      self::escapeVariable('id',$prefix) => $asso->getId(),
      self::escapeVariable('name',$prefix) => $asso->getName(),
      self::escapeVariable('website',$prefix) => $asso->getWebsite(),
    );
  }
  /**
   * Create standard variables available in all emails
   * @param $member recipient member
   */
  private static function _createStandardVariables(Member $member)
  {
    $varValues = array_merge(self::getMemberVariables($member,'recipient'),self::getAssociationVariables($member->getAssociation()));
    $varValues[self::escapeVariable('home','site')] = sfContext::getInstance()->getRouting()->generate('login',array(),true);
    return $varValues;
  }
  /**
   * Return array with variables available in all email
   */
  public static function getStandardVariablesDescription()
  {
    
    $variables = array();
    $prefix = 'recipient';
    $variables[self::escapeVariable('id',$prefix)] = 'Identifiant unique du membre';
    $variables[self::escapeVariable('name',$prefix)] = 'Prénom et nom du membre';
    $variables[self::escapeVariable('email',$prefix)] = "Email du membre (peut être vide)";
    $variables[self::escapeVariable('email_link',$prefix)] = "Lien HTML vers email du membre (si pas définit affiche '(Pas d'email)')";
    $variables[self::escapeVariable('city',$prefix)] = 'Ville du membre';
    $prefix = 'association';
    $variables[self::escapeVariable('id',$prefix)] = "Identifiant unique de l'association";
    $variables[self::escapeVariable('name',$prefix)] = "Nom du de l'association";
    $variables[self::escapeVariable('website',$prefix)] = "Site de l'association";
    
    $variables[self::escapeVariable('home','site')] = "Page de login du gestionnaire";
    return $variables;
  }
}
?>