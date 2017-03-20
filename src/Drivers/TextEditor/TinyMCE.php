<?php

namespace LiddleDev\LiddleForum\Drivers\TextEditor;

class TinyMCE implements TextEditorInterface
{
    /**
     * Returns the HTML necessary to convert a textarea input into the text editor
     *
     * @param $textareaId
     * @return string
     */
    public function applyToTextArea($textareaId)
    {
        $toolbar = config('liddleforum.text_editor.tinymce.toolbar');
        $plugins = config('liddleforum.text_editor.tinymce.plugins');

        return <<<EOF
<script>
	tinymce.init({
		selector:'#{$textareaId}',
		toolbar:'{$toolbar}',
		plugins: '{$plugins}',
		menubar: false,
		height: 200
	});
</script>
EOF;
    }

    /**
     * Return the HTML to be included in the head of the page
     *
     * @return string
     */
    public function headerIncludes()
    {
        return <<<EOF
<script src="/vendor/liddledev/liddleforum/assets/js/tinymce/tinymce.min.js"></script>
EOF;

    }

    /**
     * Return the HTML to be included in just before the body closing in the page
     *
     * @return string
     */
    public function footerIncludes()
    {
        return '';
    }
}