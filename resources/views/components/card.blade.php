@php
    $header_attrs = isset($header) 
        ? $header->attributes->merge(['class' => "border-b py-2 px-4 bg-gradient-to-l to-sky-50 from-white"])
        : "border-b py-2 px-4 bg-gradient-to-l to-sky-50 from-white";
@endphp

<div {{ $attributes->merge(['class' => 'border min-h-28 shadow rounded']) }}>
    @if( isset($header) )        
        <div {{ $header_attrs }}>
            {{ $header }}
        </div>    
    @endif
    <div {{ $body ? $body->attributes->merge(['class' => 'px-4 pb-4 pt-2']):'class="px-4 pb-4 pt-2"' }}>
        {{ $body }}
    </div>
</div>