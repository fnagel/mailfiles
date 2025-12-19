# TYPO3 Mailfiles

Simple TYPO3 CMS Extension to upload files and send download links via email.


## Description

This extension provides a simple form with a Plupload FE upload widget, a simple text input
used as mail subject, a textarea for adding a message, a "auto-send" checkbox and a submit button.

Recipient of the email is configured by TypoScript or by using an email address input field.

If the "auto-send" checkbox is checked the form will be auto submitted once uploading is completed.

See TypoScript file for more info on configuration options.

@wowaTYPO3 did an introduction of this extension in his Twitch channel, take a look here:
https://www.twitch.tv/videos/1997781074 or https://youtu.be/uzh8jgCqI5g?si=NS1JgluKexX3Fpxi&t=873

## Installation

* EXT:pluploadfe should work without problems (see Plupload FE documentation)
* Add the "Mail Files: default config"
  * set to your site configuration OR
  * static template to your TypoScript template
* Configure the plugin options via TypoScript (see static template in `Configuration/TypoScript/setup.txt`)
* Add plugin to a page and specify EXT:pluploadfe configuration record

_Note:_ Make sure to enable "Save filepaths in user session" option in Plupload FE config record!


## Related projects

* https://github.com/fnagel/pluploadfe
* https://www.plupload.com


## Contribution

Any help is appreciated. Please feel free to drop me a line, open issues or send pull requests.

It is possible to sponsor features and bugfixes!


## Donation

Please consider a donation: https://www.felixnagel.com/donate/
