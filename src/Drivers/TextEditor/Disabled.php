<?php

namespace LiddleDev\LiddleForum\Drivers\TextEditor;

class Disabled implements TextEditorInterface
{
    /**
     * Returns the HTML necessary to convert a textarea input into the text editor
     *
     * @param $textareaId
     * @return string
     */
    public function applyToTextArea($textareaId)
    {
        return '';
    }

    /**
     * Return the HTML to be included in the head of the page
     *
     * @return string
     */
    public function headerIncludes()
    {
        return '';
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