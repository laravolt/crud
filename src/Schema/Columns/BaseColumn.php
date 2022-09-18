<?php

namespace Laravolt\Crud\Schema\Columns;

use Doctrine\DBAL\Schema\Column as DoctrineColumn;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Support\Stringable;

abstract class BaseColumn implements Column
{
    protected DoctrineColumn $column;

    protected string $inputType = 'text';

    public function __construct(DoctrineColumn $column)
    {
        $this->column = $column;
    }

    #[ArrayShape([
        'name' => "string",
        'label' => Stringable::class,
        'required' => "bool",
        'type' => "string",
        'constraints' => "array",
        'metadata' => "array"
    ])]
    public function spec(): array
    {
        $titleForHuman = Str::of($this->column->getName())->title()->replace('_', ' ');

        return [
            'name' => $this->column->getName(),
            'label' => $titleForHuman,
            'required' => $this->column->getNotnull(),
            'type' => $this->inputType(),
            'constraints' => [],
            'metadata' => [
                'format' => null,
                'canSort' => true,
                'placeholder' => $titleForHuman,
                'canFilter' => true,
            ],
        ];
    }

    public function rules(): array
    {
        return ($this->column->getNotnull() && $this->column->getDefault() === null) ? ['required'] : [];
    }

    public function inputType(): string
    {
        return $this->inputType ?? $this->column->getType()->getName();
    }
}
