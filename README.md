TYPO3 Mailfiles
===============

TYPO3 CMS Extension to upload files and send download links via email.


Description
-----------

This extension provides a simple form with a Pluploadfe upload widget, a simple text input 
used as mail subject, a textarea for adding a message, a "auto-send" checkbox and a submit button.

If the "auto-send" checkbox is checked the form will be auto submitted 
once uploading is completed.


Installation
------------

* EXT:pluploadfe should work without problems (see pluploadfe documentation)
* Add "Mail Files: default config" static template to your TypoScript template.
* Configure the plugin options via TS (see static template in `Configuration/TypoScript/setup.txt`)
* Add plugin to a page and specify pluploadfe configuration record

_Note:_ Make sure to enable "Save filepaths in user session" option in pluploadfe config record!


Plupload
------------
_More info about plupload:_

http://www.plupload.com/


Contribution
------------

Any help is appreciated. Please feel free to drop me a line, open issues or send pull requests.

It is possible to sponsor features and bugfixes!


Donation
--------

Please consider a donation: http://www.felixnagel.com/donate/
