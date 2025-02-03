@props([
    'defaultValue' => null,
    'name',
    'id' => null,
    'label'=>'',
    'options' => []
])
@if ($label)
    <label class="form-label" for="{{$name}}">
        {{ $label }}
    </label>
@endif

<select 
    id="{{$id ?? $name}}"
    name="{{$name}}"
    {{$attributes->class([
        'form-select',
        'is-invalid' => $errors->has($name)
    ])}}>
    <option value="" disabled @selected($defaultValue == null)>اختر</option>
    @foreach ($options as $option)
        <option value="{{$option->id}}" @selected($defaultValue == $option->id)>{{$option->name}}</option>
    @endforeach
</select>

{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
