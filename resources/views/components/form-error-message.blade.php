@props(["name"])

@if($errors->has($name))
    <div class="text-red-500">
        {{$errors->first($name)}}
    </div>
@endif
