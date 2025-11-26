{{-- @php
    $url = Storage::disk('public')->url($getRecord()->url);
    $type = $getRecord()->type;
@endphp

@if($type === 'image')
    <img src="{{ $url }}" class="w-20 h-20 rounded-lg object-cover" />
@elseif($type === 'video')
    <video class="w-20 h-20 rounded-lg" controls>
        <source src="{{ $url }}" type="video/mp4">
    </video>
@endif --}}

@php
    $url = Storage::disk('public')->url($getRecord()->url);
    $type = $getRecord()->type;
@endphp

<div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 relative flex items-center justify-center">
    @if($type === 'image')
        <img
            src="{{ $url }}"
            class="absolute top-0 left-0 w-full h-full object-cover"
            alt="Preview"
        />
    @elseif($type === 'video')
        <video
            class="absolute top-0 left-0 w-full h-full object-cover"
            controls
            preload="metadata"
        >
            <source src="{{ $url }}" type="video/mp4">
        </video>
    @endif
</div>

