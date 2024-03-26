<?php

declare(strict_types=1);

namespace TomasVotruba\ClassLeak\ValueObject;

use JsonSerializable;
use TomasVotruba\ClassLeak\FileSystem\StaticRelativeFilePathHelper;

final readonly class FileWithClass implements JsonSerializable
{
    /**
     * @param string[] $attributes
     * @param array<string, string[]> $attributesByMethod
     */
    public function __construct(
        private string $filePath,
        private string $className,
        private bool $hasParentClassOrInterface,
        private array $attributes,
        private array $attributesByMethod,
    ) {
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getFilePath(): string
    {
        return StaticRelativeFilePathHelper::resolveFromCwd($this->filePath);
    }

    public function hasParentClassOrInterface(): bool
    {
        return $this->hasParentClassOrInterface;
    }

    /**
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<string, string[]>
     */
    public function getAttributesByMethod(): array
    {
        return $this->attributesByMethod;
    }

    /**
     * @return array{file_path: string, class: string, attributes: string[], attributesByMethod: array<string, string[]>}
     */
    public function jsonSerialize(): array
    {
        return [
            'file_path' => $this->filePath,
            'class' => $this->className,
            'attributes' => $this->attributes,
            'attributesByMethod' => $this->attributesByMethod,
        ];
    }
}
