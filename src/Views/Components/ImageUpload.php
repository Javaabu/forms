<?php

namespace Javaabu\Forms\Views\Components;

class ImageUpload extends Image
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string            $name,
        string            $label = '',
        string|array      $type = 'image',
        null|string|array $mimetypes = null,
        null|string|array $extensions = null,
        ?int              $maxSize = null,
        string            $collection = '',
        string            $conversion = '',
        string            $fileInputClass = '',
        string            $icon = '',
        string            $uploadIcon = '',
        int        $width = 400,
        int        $height = 400,
        bool       $cover = false,
        bool       $fullwidth = false,
        bool       $maintainAspectRatio = true,
        bool       $circle = false,
        ?float            $aspectRatio = null,
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
            icon: $icon,
            uploadIcon: $uploadIcon,
            width: $width,
            height: $height,
            cover: $cover,
            fullwidth: $fullwidth,
            maintainAspectRatio: $maintainAspectRatio,
            circle: $circle,
            upload: true,
            aspectRatio: $aspectRatio,
            model: $model,
            default: $default,
            showHint: $showHint,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required: $required,
            disabled: $disabled,
            ignoreAccessor: $ignoreAccessor,
            inline: $inline,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );
    }
}
