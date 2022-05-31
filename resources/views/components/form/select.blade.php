@php
    /*
    *************************************************
            Properties to use the select component
                         @select()
    *************************************************
     @property string        $label      => Set label name
     @property string        $name       => Set name for input
     @property string|null   $selected   => Option value selected
     @property string|null   $errorName  => Set key for errors, use the $name as the default value
     @property string|null   $labelClass => Use set class label
     @property string|null   $placeHolder=> Use set placeHolder select
     @property string|null   $id         => Use set Id to input
     @property string|null   $class      => Use set class Form Group
     @property string|null   $inputClass => Set class of input
     @property string[]|null $properties => Array of properties example ['disabled' => true ]
     @property string[]|null $options    => Array of options example [1 => Hombre ],If not specified, it will show a "---"
     */

    $properties=$properties??[];
    $options=$options??[];
    $selected=$selected??"";
    $errorName=$errorName??"";
@endphp

<div class="{{$class??""}}">
    <label class="{{$labelClass??null}} form-label"
           for="{{$id??$name}}">{{$label}}</label>
    <select id="{{$id??$name}}"
            class="form-control {{$inputClass??""}} {{ isset($errors)  ? ($errors->has($errorName) ? ' is-invalid' : '') : '' }}"
            name="{{$name}}"
    @forelse($properties as $property=>$value)
        {{$property}}="{{$value}}"
    @empty

    @endforelse
    >
    @if(isset($placeHolder))
        <option selected value="0">{{$placeHolder}}</option>
    @endif
    @forelse($options as $value=>$option)
        @if($value === $selected)
            <option selected value="{{$value}}">{{$option}}</option>
        @else
            <option value="{{$value}}">{{$option}}</option>
            @endif
            @empty
            @endforelse
            </select>
            <span class="invalid-feedback">{{ isset($errors) ? ($errors->first($errorName)) : '' }}</span>
</div>
