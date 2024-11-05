<?php

namespace Javaabu\Forms\Views\Components;

class Image extends File
{
    protected string $view = 'image';

    public string $icon;
    public float $aspectRatio;

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
        public int        $width = 400,
        public int        $height = 400,
        public bool       $cover = false,
        public bool       $fullwidth = false,
        public bool       $maintainAspectRatio = true,
        public bool       $circle = false,
        bool       $upload = false,
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
        string            $framework = ''
    )
    {
        parent::__construct(
            $name,
            label: $label,
            type: $type,
            mimetypes: $mimetypes,
            extensions: $extensions,
            maxSize: $maxSize,
            collection: $collection,
            conversion: $conversion,
            fileInputClass: $fileInputClass,
            uploadIcon: $uploadIcon,
            model: $model,
            default: $default,
            showHint: $showHint,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required: $required,
            disabled: $disabled,
            ignoreAccessor: $ignoreAccessor,
            upload: $upload,
            inline: $inline,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            framework: $framework
        );

        $this->icon = $icon ?: $this->getFrameworkIcon($this->frameworkConfig('image-icon'));

        if ($this->circle) {
            $aspectRatio = 1;
        }

        $this->aspectRatio = $aspectRatio ?: ($width ? $this->height / $this->width : 1);
    }

    public function getImageHint(): string
    {
        return trans('forms::strings.image_hint', [
            'width' => $this->width,
            'height' => $this->height,
        ]);
    }
}
