<?php

namespace Javaabu\Forms\Support;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HandlesMediaValues
{
    use HandlesBoundValues;

    protected function getBoundValue($bind, string $name)
    {
        if ($bind === false) {
            return null;
        }

        $bind = $bind ?: $this->getBoundTarget();

        // get the bound value normally
        $boundValue = data_get($bind, $name);

        // otherwise try to get the file media
        if (empty($boundValue) && $bind instanceof HasMedia) {
            return $bind->getMedia($this->collection)->first();
        }

        return $boundValue;
    }

    protected function setValue(string $name, $bind = null, $default = null)
    {
        $inputName = static::convertBracketsToDots($name);

        $boundValue = $this->getBoundValue($bind, $inputName);

        $default = is_null($boundValue) ? $default : $boundValue;

        return $this->value = old($inputName, $default);
    }

    protected function getFileUrl($media): ?string
    {
        if ($media instanceof Media) {
            if ($this->conversion !== '' && ! $media->hasGeneratedConversion($this->conversion)) {
                return $media->getUrl();
            }

            return $media->getUrl($this->conversion);
        }

        return is_string($media) ? $media : '';
    }
}