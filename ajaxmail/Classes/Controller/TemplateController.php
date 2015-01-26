<?php
namespace TRENDMARKE\Ajaxmail\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Julian Ereth <info@trendmarke.de>, trendmarke GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 *
 *
 * @package ajaxmail
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class TemplateController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * templateRepository
     *
     * @var \Trendmarke\Ajaxmail\Domain\Repository\TemplateRepository
     * @inject
     */
    protected $templateRepository;

	/**
	 * action edit
	 *
     * @return \string JSON
	 */
	public function sendAction() {
        $arguments = $this->request->getArguments();
        $success = true;
        $template = $this->templateRepository->findByUid($this->request->getArgument('tid'));

        // validate template
        if (!$template || $template==NULL) {
            return json_encode(array(
                'success' => false,
                'msg'   => 'Mail-Template not found'
            ));
        } else {
            // REPLACE PLACEHOLDER Argument example will replace {example}
            $argument_text = array();
            $placeholder_text = array();
            $all_value = '';
            // Make replace arrays
            foreach ($this->request->getArguments() as $key => $arg) {
                $argument_text[] = $arg;
                $placeholder_text[] = '{'.$key.'}';
                if ($key!='tid') $all_value .= $key.': '.$arg.'<br />';
            }
            $argument_text[] = $all_value;
            $placeholder_text[] = '{all}';
            // Replace in all fields
            $subject = str_replace($placeholder_text, $argument_text, $template->getSubject());
            $body = str_replace($placeholder_text, $argument_text, $template->getMessage());
            $confirmationReceiver = str_replace($placeholder_text, $argument_text, $template->getConfirmationReceiver());
            $confirmationMessage = str_replace($placeholder_text, $argument_text, $template->getConfirmationMessage());
            $confirmationSubject = str_replace($placeholder_text, $argument_text, $template->getConfirmationSubject());

            // SEND MAIL
            try {
                $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
                $message->setFrom(array($template->getSender() => $template->getSenderName()))
                    ->setTo(array($template->getReceiver()))
                    ->setSubject($subject)
                    ->setBody($body, 'text/html');
                // CC
                 foreach (explode (',',$template->getCc()) as $cc) {
                     if (\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($cc)) $message->addCc($cc);
                 }
                // BCC
                foreach (explode (',',$template->getBcc()) as $bcc) {
                    if (\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($bcc)) $message->addBcc($bcc);
                }
                $message->send();
            } catch (Exception $e) {
                $success = false;
            }
            // SEND CONFIRMATION MAIL
            if ($confirmationReceiver!='' && $confirmationMessage!='') {
                try {
                    $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
                    $message->setFrom(array($template->getSender() => $template->getSenderName()))
                        ->setTo(array($confirmationReceiver))
                        ->setSubject($confirmationSubject)
                        ->setBody($confirmationMessage, 'text/html');
                        $message->send();
                } catch (Exception $e) {
                    $success = false;
                }
            }

        }

        return json_encode(array(
            'success' => $success,
        ));
	}



}
?>