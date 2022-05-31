@php
    /*
    *************************************************
            Properties to use the input component
                         @input()
    *************************************************
     @property string        $label      => Set label name
     @property string        $name       => Set name for input
     @property string|null   $errorName  => Set key for errors, use the $name as the default value
     @property string|null   $type       => Set type of input use "text" as the default value
     @property string|null   $value      => Set value for input
     @property string|null   $labelClass => Use set class label
     @property string|null   $class      => Use set class Form Group
     @property string|null   $id         => Use set Id to input
     @property string|null   $autocomplete => Use set autocomplete On/Off
     @property string|null   $inputClass => Set class of input
     @property string|null   $search     => route for autocomplete search
     @property string|null   $method     => Post/Get for autocomplete search
     @property string[]|null $properties => Array of properties example ['disabled' => true ]
     */
    $name=$name??'';
    $type=$type??'text';
    $properties=$properties??[];
    $errorName=$errorName??$name;
@endphp

@if($type ==='hidden')
    <input
        id="{{$id??""}}"
        type="hidden"
        class="{{$inputClass?? ""}}"
        autocomplete="{{$autocomplete??""}}"
        value="{{$value??""}}"
        name="{{$name}}"
    @forelse($properties as $property=>$value)
        {{$property}}="{{$value}}"
    @empty

    @endforelse
    >
@elseif($type =='autocomplete')

    <!-- For defining autocomplete -->
    <div @forelse($properties as $property=>$propValue) {{$property}}="{{$propValue}}" @empty @endforelse >
        <label class="form-label" for="{{$name}}_autocomplete">{{$label}}</label>
        <input type="text" id='{{$name}}_autocomplete' class="form-control" name="{{$name}}_autocomplete" value="{{$selected??""}}" autocomplete="off" autocomplete="chrome-off" />
        <input
            id="{{$id??""}}_{{$name}}_search"
            type="hidden"
            value="{{$value??""}}"
            name="{{$name}}"
        />
    </div>

    <!-- Script -->
    <script type="text/javascript">

        if (typeof {{$name}}_autocomplete !== 'undefined') {
            let {{$name}}_autocomplete = new autoComplete({
                selector: "#{{$name}}_autocomplete",
                wrapper: true,
                data: {
                    src:
                        @if($method == "remote")
                        async () => {
                            try {
                                const source = await fetch("{{$search}}");
                                const data = await source.json().then(data => data.suggestions);
                                return data;
                            } catch (error) {
                                return error;
                            }
                        }
                    @elseif($method == "local")
                        {!! json_encode($search) !!}
                        @endif
                    ,
                    keys: {!!  $keys??'["id","value"]' !!},
                },
                placeHolder: "Escribe para buscar",
                resultsList: {
                    element: (list, data) => {
                        const info = document.createElement("p");
                        info.innerHTML = `Existen <strong>${data.matches.length}</strong> results`;
                        list.prepend(info);
                    },
                    noResults: true,
                    maxResults: 5,
                    tabSelect: true
                },
                resultItem: {
                    element: (item, data) => {
                        item.style = "display: flex; justify-content: space-between;";
                        item.innerHTML = `
                        <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">${data.match}</span>
                        <span style="display: flex; align-items: center; font-size: 13px; font-weight: bold; text-transform: uppercase; color: rgba(0,0,0,.2);"> {{isset($show_on_right) ? '${data.value.'.$show_on_right.'}' : ''}} </span>`;
                    },
                    highlight: false
                },
                events: {
                    input: {
                        focus: () => {
                            if ({{$name}}_autocomplete.input.value.length) {{$name}}_autocomplete.start();
                        }
                    }
                }
            });

            {{$name}}_autocomplete.input.addEventListener("selection", function (event) {
                const feedback = event.detail;
                {{$name}}_autocomplete.input.blur();
                const selection = feedback.selection.value[feedback.selection.key];
                {{$name}}_autocomplete.input.value = selection;
                $('#{{$id??""}}_{{$name}}_search').val(feedback.selection.value.id);

                @if(isset($onSelect))
                const onSelectEvent = new CustomEvent('{{$onSelect}}', { detail: feedback.selection });
                document.dispatchEvent(onSelectEvent);
                @endif
            });
        }

    </script>


@else
    <div class="form-group {{$class ?? ""}}">
        <label class="form-label {{$labelClass??null}}"
               for="{{$id ?? $name}}">{{$label}}</label>
        <input id="{{$id ?? $name}}"
               type="{{$type}}"
               class="form-control {{$inputClass??""}} {{ isset($errors)  ? ($errors->has($errorName) ? ' is-invalid' : '') : '' }}"
               name="{{$name??""}}"
               autocomplete="{{$autocomplete??""}}"
               value="{{ $value ?? null }}"
        @forelse($properties as $property=>$value)
            @if($property == 'disabled')
                @if($value == true)
                    disabled
                @endif
            @else
                {{$property}}="{{$value}}"
            @endif
        @empty

        @endforelse
        />
        <span class="invalid-feedback">{{ isset($errors) ? ($errors->first($errorName)) : '' }}</span>
    </div>
@endif

