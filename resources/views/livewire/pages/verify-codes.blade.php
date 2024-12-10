<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\VerifyCode;
use Illuminate\Pagination\LengthAwarePaginator;

new #[Layout('layouts.custom')] class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            'codes' => VerifyCode::query()->whereIsSent(true)->orderByDesc('id')->paginate(10),
        ];
    }
}
?>
<div class="p-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center border-b pb-2">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold text-gray-900">Verify Codes</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all verify codes.</p>
        </div>
    </div>
    <div class="mt-6 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Phone
                                Number
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Platform
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Code</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sent At
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Expired
                                At
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">

                        @foreach($codes as $code)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    {{ $code->mobile }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $code->platform }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><code class="bg-green-200/80 px-2 py-1 text-xs text-green-800 rounded-2xl">{{ $code->code }}</code></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $code->sent_at }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $code->expired_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if($codes->hasPages())
                    <div class="mt-4">
                        {{ $codes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>