<?php

namespace Javaabu\Forms\Views\Components;

class FileUpload extends File
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string            $name,
        string            $label = '',
        string|array      $type = 'document',
        null|string|array $mimetypes = null,
        null|string|array $extensions = null,
        ?int              $maxSize = null,
        string            $collection = '',
        string            $conversion = '',
        string            $fileInputClass = '',
        string            $clearIcon = '',
        string            $downloadIcon = '',
        string            $uploadIcon = '',
                          $model = null,
                          $default = null,
        bool              $showHint = true,
        bool              $showErrors = true,
        bool              $showLabel = true,
        bool              $required = false,
        bool              $disabled = false,
        bool              $ignoreAccessor = false,
        bool              $inline = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
        string            $framework = ''
    )
    {
        parent::__construct(
            name: $name,
            label: $label,
            type: $type,
            mimetypes: $mimetypes,
            extensions: $extensions,
            maxSize: $maxSize,
            collection: $collection,
            conversion: $conversion,
            fileInputClass: $fileInputClass,
            clearIcon: $clearIcon,
            downloadIcon: $downloadIcon,
            uploadIcon: $uploadIcon,
            model: $model,
            default: $default,
            showHint: $showHint,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required: $required,
            disabled: $disabled,
            ignoreAccessor: $ignoreAccessor,
            upload: true,
            inline: $inline,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );
    }
}
