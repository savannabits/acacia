@props(['borderClass' => 'border-green-400','backgroundClass' => 'bg-green-400'])
<div {{$attributes->merge(['class' => "widget w-full p-4 rounded-lg bg-white border-l-4 $borderClass"])}}>
    <div class="flex items-center">
        <div {{$attributes->merge(['class' => "icon w-14 h-14 p-2 flex items-center justify-center text-white rounded-full mr-3 $backgroundClass"])}}>
            @if(isset($icon))
                {{$icon}}
            @else
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            @endif
        </div>
        <div class="flex flex-col justify-center">
            {{$slot}}
        </div>
    </div>
</div>
