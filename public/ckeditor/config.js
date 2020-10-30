/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';


    config.toolbarGroups = [
        { name: 'document', groups: ['mode', 'document', 'doctools'] },
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
        { name: 'forms', groups: ['forms'] },
        { name: 'insert', groups: ['insert'] },
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        { name: 'colors', groups: ['colors'] },
        { name: 'styles', groups: ['styles'] },
        '/',
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
        { name: 'links', groups: ['links'] },
        '/',
        { name: 'tools', groups: ['tools'] },
        { name: 'others', groups: ['others'] },
        { name: 'about', groups: ['about'] }
    ];

    config.removeButtons = 'Save,Templates,Source,Find,SelectAll,Outdent,Indent,Blockquote,CreateDiv,BidiRtl,BidiLtr,Language,ShowBlocks,Maximize,About,Flash,HorizontalRule,PageBreak,Iframe,Anchor,Unlink,Link,NewPage,ExportPdf,Preview,Print,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Subscript,Superscript,RemoveFormat,Scayt,Replace,Undo,Redo,SpecialChar,Table,NumberedList,BulletedList,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,Styles,Format,Font,CopyFormatting,Strike,PasteText,Cut,Copy,BGColor,PasteFromWord';



};