mod.wizards.newContentElement.wizardItems.plugins {
	elements.mailfiles {
		iconIdentifier = extensions-mailfiles-wizard
		title = LLL:EXT:mailfiles/locallang.xml:pi1_title
		description = LLL:EXT:mailfiles/locallang.xml:pi1_plus_wiz_description
		tt_content_defValues.CType = list
		tt_content_defValues.list_type = mailfiles_pi1
	}

	show := addToList(mailfiles)
}