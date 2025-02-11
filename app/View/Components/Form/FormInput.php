<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @var string
     */
    public $value;

    /**
     * @var mixed|string
     */
    public $oldName;

    /**
     * @var mixed|string
     */
    public $type;

    /**
     * @var bool
     */
    public $isRequired;

    /**
     * @var bool
     */
    public $readonly;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $label,
        $id,
        $name,
        $placeholder = '',
        $value = '',
        $oldName = '',
        $type = 'text',
        $isRequired = false,
        $readonly = false
    ) {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->oldName = $oldName;
        $this->isRequired = $isRequired;
        $this->type = $type;
        $this->isRequired = $isRequired;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.form-input');
    }
}
