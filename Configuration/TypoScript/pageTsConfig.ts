mod.wizards.newContentElement.wizardItems.plugins {
	elements.mailfiles {
		iconIdentifier = extensions-mailfiles-wizard
		# Fallback for TYPO3 6.2
		icon = ../typo3conf/ext/mailfiles/pi1/ce_wiz.gif
		title = LLL:EXT:mailfiles/locallang.xml:pi1_title
		description = LLL:EXT:mailfiles/locallang.xml:pi1_plus_wiz_description
		tt_content_defValues.CType = list
		tt_content_defValues.list_type = mailfiles_pi1
	}
}