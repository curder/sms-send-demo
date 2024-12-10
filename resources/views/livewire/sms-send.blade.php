<div>
    @unless($is_sent)
        <x-primary-button class="py-2.5" wire:loading.remove wire:click="send" type="button">获取验证码</x-primary-button>
        <x-secondary-button class="py-2.5" style="display: none;" wire:loading wire:target="send">...</x-secondary-button>
    @else
        <x-secondary-button class="py-2.5" disabled wire:poll.1s="decrease" type="button">{{ $second }}秒</x-secondary-button>
    @endunless
</div>
