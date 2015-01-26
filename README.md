# AjaxMail for Typo3

## Description
This is a Typo3 Extension that allows you to easily send Mails from any form in your website via Ajax. 

The Extension was created to have a quick way to add easy contact forms on modern Typo3 Fluid websites. 
The idea is that you can add a form anywhere on the website and submit it via ajax to send the mail.

## Requirements
- JQuery v1

## Installation
1. Copy the folder ajaxmail to your typo3conf/ext/ directory
2. Install the extension with your Typo3 Extension Manager 
3. Add the static TS-Template to your template
4. Add the file typo3conf/ext/ajaxmail/Resources/Public/Js/ajaxmail.js to your website
5. That's it - Read **How to use it** to learn more

## How to use it
1. Add a new Sys-Folder to your Typo3 pagetree
2. Add a Mail Template (content element ) and fill it as you want. 
	* Set sender, receiver and so on. You can use variables by using {} - learn more about that in a second
	* Remember the UID of your form 
3. Add a form to your website. Look at this example
```
<form method="post" class="ajaxMail">
	<input type="hidden" name="tx_ajaxmail_ajax[tid]" value="1" />
	<input type="text" placeholder="Name" name="tx_ajaxmail_ajax[Name]" required/>
	<input type="email" placeholder="Email*" name="tx_ajaxmail_ajax[Email]" required/>
	<textarea name="tx_ajaxmail_ajax[Comments]" placeholder="Comments ..."></textarea>
	<input type="submit" value="send" />
</form>
```
* Important: Form has to have the class ajaxMail
* Important: there must be a field with the name tx_ajaxmail_ajax[tid] that has the UID of your template as value
* Important: All fields that you need in your mail have to have a name like: tx_ajaxmail_ajax[...]

## Variables
* You can easily use variables in your Mail Template by wraping {} around the variable name.
* If you want to acceess the name field in the example just write {Name}
* You can use {all} as a special variable that lists all submited variables in a list e.g. Name: John, Email: john@doe.de ...
* You can also use the variables in the subject, receiver and all other field e.g. if you want to send a confirmation mail to the user just add {Email} as the confirmation receiver

## ToDo
* Localization
* Attachments
