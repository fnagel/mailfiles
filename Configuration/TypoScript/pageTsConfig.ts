mod.wizards.newContentElement.wizardItems.plugins {
	elements.mailfiles {
		iconIdentifier = extensions-mailfiles-wizard
		# Fallback for TYPO3 6.2
		icon = ../typo3conf/ext/mailfiles/Resources/Public/Icons/plugin.png
		title = LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.title
		description = LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.description
		tt_content_defValues.CType = list
		tt_content_defValues.list_type = mailfiles_pi1
	}
}
