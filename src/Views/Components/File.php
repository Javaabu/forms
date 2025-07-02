<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Arr;
use Javaabu\Forms\Support\HandlesMediaValues;
use Javaabu\Helpers\Media\AllowedMimeTypes;

class File extends Input
{
    protected string $view = 'file';

    use HandlesMediaValues;

    public array $fileTypes;
    public array $mimetypes;
    public string $collection;
    public string $conversion;
    public string $fileInputClass;
    public array $extensions;
    public int $maxSize;
    public bool $showHint;
    public string $fileName = '';
    public string $clearIcon;
    public string $downloadIcon;
    public string $uploadIcon;

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
        bool $showErrors = true,
        bool $showLabel = true,
        bool $required = false,
        public bool $disabled = false,
        public bool $ignoreAccessor = false,
        public bool       $upload = false,
        bool $inline = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
        string $framework = ''
    ) {
        $this->showHint = $showHint;
        $this->collection = $collection ?: $name;
        $this->conversion = $conversion;
        $this->fileInputClass = $fileInputClass;
        $this->fileTypes = Arr::wrap($type);
        $this->mimetypes = $mimetypes ? Arr::wrap($mimetypes) : AllowedMimeTypes::getAllowedMimeTypes($this->fileTypes);
        $this->extensions = $extensions ? Arr::wrap($extensions) : AllowedMimeTypes::getExtensions($this->mimetypes);
        $this->maxSize = $maxSize ?: AllowedMimeTypes::getMaxFileSize($this->fileTypes);

        parent::__construct(
            $name,
            label: $label,
            type: 'file',
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required:$required,
            inline: $inline,
            floating: false,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );

        $this->downloadIcon = $downloadIcon ?: $this->getFrameworkIcon($this->frameworkConfig('file-download-icon'));
        $this->uploadIcon = $uploadIcon ?: $this->getFrameworkIcon($this->frameworkConfig('file-upload-icon'));
        $this->clearIcon = $clearIcon ?: $this->getFrameworkIcon($this->frameworkConfig('file-clear-icon'));
    }

    public function getHint(): string
    {
        return trans('forms::strings.file_hint', [
            'types' => collect($this->extensions)
                        ->map(fn($ext) => '.' . $ext)
                        ->join(trans('forms::strings.text_list_separator'), trans('forms::strings.text_list_separator_last_glue')),

            'size' => format_file_size($this->maxSize),
        ]);
    }

    public function isFileInput(): bool
    {
        return true;
    }
}
