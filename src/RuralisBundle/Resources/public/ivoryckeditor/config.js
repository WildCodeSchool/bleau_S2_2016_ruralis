/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.toolbar_Basic = [
        [ 'Source', '-', 'Bold', 'Italic' ]
    ];
// Load toolbar_Name where Name = Basic.
    config.toolbar = 'Basic';
    config.extraPlugins = 'youtube';
    config.toolbar = [{ name: 'insert', items: ['Image', 'Youtube']}];
};
