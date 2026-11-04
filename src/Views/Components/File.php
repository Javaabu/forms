<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Arr;
use Javaabu\Forms\Assets\Assets;
use Javaabu\Forms\Support\HandlesMediaValues;
use Javaabu\Forms\Support\Settings;
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
        string $name,
        string $label = '',
        string|array $type = 'document',
        null|string|array $mimetypes = null,
        null|string|array $extensions = null,
        ?int $maxSize = null,
        string $collection = '',
        string $conversion = '',
        string $fileInputClass = '',
        string $clearIcon = '',
        string $downloadIcon = '',
        string $uploadIcon = '',
        $model = null,
        $default = null,
        bool $showHint = true,
        bool $showErrors = true,
        bool $showLabel = true,
        bool $required = false,
        public bool $disabled = false,
        public bool $ignoreAccessor = false,
        public bool $upload = false,
        bool $inline = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
        public bool $multiple = false,
        string $framework = ''
    ) {
        $this->showHint = $showHint;
        $this->collection = $collection ?: $name;
        $this->conversion = $conversion;
        $this->fileInputClass = $fileInputClass;
        $this->fileTypes = Arr::wrap($type);
        $this->mimetypes = $mimetypes ? Arr::wrap($mimetypes) : AllowedMimeTypes::getAllowedMimeTypes($this->fileTypes);
        $this->extensions = $extensions ? Arr::wrap($extensions) : AllowedMimeTypes::getExtensions($this->mimetypes);
        $this->maxSize = $maxSize ?: (
            function_exists('get_setting')
                ? AllowedMimeTypes::getMaxFileSize($this->fileTypes)
                : (int) Settings::get('max_upload_file_size', 10240)
        );

        parent::__construct(
            $name,
            label: $label,
            type: 'file',
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required: $required,
            inline: $inline,
            floating: false,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );

        $this->downloadIcon = $downloadIcon ?: $this->getFrameworkIcon('download');
        $this->uploadIcon = $uploadIcon ?: $this->getFrameworkIcon('upload');
        $this->clearIcon = $clearIcon ?: $this->getFrameworkIcon('clear');
    }

    public function getHint(): string
    {
        return trans('forms::strings.file_hint', [
            'types' => collect($this->extensions)
                ->map(fn ($ext) => '.' . $ext)
                ->join(trans('forms::strings.text_list_separator'), trans('forms::strings.text_list_separator_last_glue')),

            'size' => format_file_size($this->maxSize),
        ]);
    }

    public function isFileInput(): bool
    {
        return true;
    }

    /** @return array<int, string> */
    public function assets(): array
    {
        return [Assets::CORE, Assets::FILES];
    }
}
