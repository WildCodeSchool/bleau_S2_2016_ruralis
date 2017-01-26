/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
/*
    config.removeDialogTabs = 'image:advanced;image:Link';
*/
    config.extraPlugins = 'youtube';
    config.toolbar = [{ name: 'insert', items: ['Youtube']}];
};
