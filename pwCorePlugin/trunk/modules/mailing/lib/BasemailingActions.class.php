<?php

/**
 * mailing actions.
 *
 * @package    piwam
 * @subpackage mailing
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class BasemailingActions extends sfActions
{
  /**
   * Executes Index action. Send email to each member if form has been
   * submit.
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new MailingForm(array(), array('url' => $this->getController()->genUrl('membre/ajaxlist')));
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('mailing'));
      if ($this->form->isValid())
      {
        $associationId = $this->getUser()->getAssociationId();
        $data   = $this->form->getValues();
        $sentOk = 0;    // these are 2 counters of
        $sentKo = 0;    // succeed/failed messages

        try
        {
          $mailer     = MailerFactory::get($associationId, $this->getUser());
          $from_email = Configurator::get('address', $associationId, 'info-association@piwam.org');
          $from_label = $this->getUser()->getAssociationName('Piwam');
          $members    = MemberTable::getHavingEmailForAssociation($this->getUser()->getAssociationId());
          $to         = array();

          foreach ($members as $member)
          {
            try
            {
              $message = Swift_Message::newInstance($data['subject'])
                          ->setBody($data['mail_content'])
                          ->setContentType('text/html')
                          ->setFrom(array($from_email => $from_label))
                          ->setTo(array($member->getEmail() => $member->getFirstname()));
              $mailer->send($message);
              $sentOk++;
            }
            catch(Swift_ConnectionException $e)
            {
              $sentKo++;
            }

            $to[$member->getEmail()] = $member->getFirstname() . ' ' . $member->getLastname();
          }

          sfContext::getInstance()->getConfiguration()->loadHelpers('Plural');
          $this->getUser()->setFlash('notice', 'Votre message a été envoyé à ' . $sentOk . plural_word($sentOk, ' destinataire') . ' (' . $sentKo . plural_word($sentKo, ' erreur') . ')');
          $this->content = $data['mail_content'];

          // Record the sent mail
          $sentMail = new SentMail();
          $sentMail->setObject($data['subject']);
          $sentMail->setMessage($data['mail_content']);
          $sentMail->setAssociationId($associationId);
          $sentMail->setTo($to);
          $sentMail->setSentBy($this->getUser()->getUserId());
          $sentMail->save();
        }
        catch (Exception $e)
        {
          echo $e;
          $this->getUser()->setFlash('error', 'Erreur');
        }
      }
    }
  }
}