This extension provides a simple form with a pluploadfe jQuery UI upload 
widget, a textarea for adding a message, a "auto-send" checkbox and a 
submit button.

If the "auto-send" checkbox is checked the form will be auto submitted 
once uploading is completed.

Installation:
* EXT:pluploadfe should work without problems (see pluploadfe documentation)
* Add "default configuration" static template to your root template.
* Add needed "form configuration" static template to your root template.
* Configure the plugin options via TS (see static template in pi1/static/setup.txt)
* Add plugin to a page and specify pluploadfe configuration record

Please note:
You need to use the "new form configuration" static TS config if EXT:form is installed!

See here for more info: 
http://wiki.typo3.org/TYPO3_4.6#Form
http://typo3.org/news/article/new-form-object/


More info about plupload:
EXT:pluploadfe documentation
http://www.plupload.com/