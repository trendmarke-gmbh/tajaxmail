<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}




TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Ajax Mail');


TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmail_domain_model_template', 'EXT:ajaxmail/Resources/Private/Language/locallang_csh_tx_ajaxmail_domain_model_template.xml');
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmail_domain_model_template');
$TCA['tx_ajaxmail_domain_model_template'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:ajaxmail/Resources/Private/Language/locallang_db.xml:tx_ajaxmail_domain_model_template',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Template.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmail_domain_model_template.gif'
	),
);

?>