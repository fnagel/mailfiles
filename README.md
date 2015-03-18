TYPO3 Mailfiles
===============

TYPO3 CMS Extension to upload files and send download links via email.


Description
-----------

This extension provides a simple form with a pluploadfe jQuery UI upload 
widget, a textarea for adding a message, a "auto-send" checkbox and a 
submit button.

If the "auto-send" checkbox is checked the form will be auto submitted 
once uploading is completed.


Installation
------------

* EXT:pluploadfe should work without problems (see pluploadfe documentation)
* Add "default configuration" static template to your root template.
* Add needed "form configuration" static template to your root template.
* Configure the plugin options via TS (see static template in pi1/static/setup.txt)
* Add plugin to a page and specify pluploadfe configuration record

Please note:
You need to use the "new form configuration" static TS config if EXT:form is installed!

_See here for more info:_
http://wiki.typo3.org/TYPO3_4.6#Form
http://typo3.org/news/article/new-form-object/


Plupload
------------
_More info about plupload:_

http://www.plupload.com/


ToDo
----

* Refactor this extension


Contribution
------------

Any help is appreciated. Please feel free to drop me a line, open issues or send pull requests.

It is possible to sponsor features and bugfixes!


Donation
--------

Please consider a donation: http://www.felixnagel.com/donate/



