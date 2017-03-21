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
        $configString = '';

        $config = config('liddleforum.text_editor.drivers.tinymce.config', []);
        foreach ($config as $key => $value) {
            $configString .= ',' . $key . ': ' . $value;
        }

        return <<<EOF
<script>
	tinymce.init({
		selector:'#{$textareaId}'
		{$configString}
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