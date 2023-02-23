<div class="p-2">
    <style>
        h1 {
            margin: 1.5rem;
        }
    </style>

    @if(auth()->guest())
        <div class="container flex flex-col items-center justify-center space-y-12 m-auto min-h-screen">
            <div class="text-center space-y-1">
                <p class="text-5xl text-teal-100">What is this Life?</p>
                <div class="space-x-4">
                    <span class="text-teal-100">What is this, Life?</span>
                    <span class="text-teal-100">What, is this Life?</span>
                </div>
            </div>

            <div class="flex flex-col bg-white text-teal-600 rounded-lg shadow space-y-4 p-8">
                <p>If this is Maggie, you'll know the secret password :)</p>

                <input wire:keydown.enter="login()" wire:model="password" type="password" class="border rounded p-2">

                <button wire:click="login" class="bg-teal-500 text-white rounded-lg shadow px-4 py-2">Login</button>
                @error('login') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
        </div>
    @else
        <button wire:click="logout" class="bg-teal-200 text-teal-600 rounded px-4 py-2">Logout</button>

        <div style="max-width: 800px;" class="container flex flex-col space-y-4 w-full mt-16 m-auto pb-12">
            <div>
                <p class="text-sm text-teal-200">- To add a line break, simply put a "#" in a line.</p>
            </div>

            <div class="bg-teal-200 rounded-lg p-4">
                <textarea wire:model="message" tabindex="1"
                    placeholder="Write your message here..."
                    class="p-2 bg-transparent placeholder-teal-500 text-teal-800 border-none shadow-none outline-none w-full"
                    rows="10"
                ></textarea>

                <div class="flex flex-wrap grid grid-cols-2 gap-2">
                    <span wire:click="saveMessage()"
                        class="bg-teal-300 text-teal-800 text-center rounded cursor-pointer px-4 py-2 w-full hover:bg-teal-400"
                    >Save Draft</span>

                    <span wire:click="saveMessage()"
                        class="bg-green-400 text-green-800 text-center rounded cursor-pointer px-4 py-2 w-full hover:bg-green-500"
                    >Publish</span>
                </div>
            </div>

            <div x-data="{ show: @entangle('drafts') }" class="space-y-2">
                <div><span @click="show = ! show" class="bg-teal-600 text-teal-100 rounded-lg cursor-pointer px-2 py-1 hover:bg-teal-400">Draft Messages ({{ count($this->draftMessages) }})</span></div>

                <ul x-show="show" class="bg-white list list-inside rounded-lg divide-y space-y-4 p-6">
                    @foreach($this->draftMessages as $message)
                        <li>
                            <div class="{{ $loop->first ? '' : 'pt-4' }}">
                                <div class="flex {{ $message->user->id == 1 ? 'justify-end' : 'justify-start' }} items-start space-x-3">
                                    <div class="flex flex-col w-3/4 {{ $message->user->id == 1 ? 'items-end' : 'items-start' }}">
                                        <div class="flex items-center text-xs space-x-2">
                                            <div class="flex items-center">
                                                @if($message->user->is(auth()->user()))
                                                    <span wire:click="publish({{ $message->id }})" class="bg-green-200 text-green-600 text-base rounded cursor-pointer px-1 mr-1 hover:bg-green-300">Publish</span>
                                                @endif

                                                @if($message->user->is(auth()->user()))
                                                    <i wire:click="delete({{ $message->id }})" class="material-icons text-gray-400 text-base rounded-lg cursor-pointer px-1 mr-1 hover:bg-gray-200">delete</i>
                                                @endif
                                                <span class="font-medium text-gray-500">{{ $message->user->name }}</span>
                                            </div>
                                            <span class="text-gray-500">{{ $message->created_at->format('M j g:ia') }}</span>
                                        </div>
                                        <div class="{{ $message->user->id == 1 ? 'text-teal-700' : 'text-purple-700' }}">
                                            <p>{{ Illuminate\Mail\Markdown::parse($message->message) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <span class="text-white">Published</span>

                <ul id="messages" class="bg-white list list-inside rounded-lg divide-y overflow-scroll space-y-4 p-6" style="max-height: 1000px;">
                    @foreach($this->messages as $message)
                        <li>
                            <div class="{{ $loop->first ? '' : 'pt-4' }}">
                                <div class="flex {{ $message->user->id == 1 ? 'justify-end' : 'justify-start' }} items-start space-x-3">
                                    <div class="flex flex-col w-3/4 {{ $message->user->id == 1 ? 'items-end' : 'items-start' }}">
                                        <div class="flex items-center text-xs space-x-2">
                                            <div class="flex items-center">
                                                @if($message->user->is(auth()->user()))
                                                    <i wire:click="delete({{ $message->id }})" class="material-icons text-gray-400 text-base rounded-lg cursor-pointer px-1 mr-1 hover:bg-gray-200">delete</i>
                                                @endif
                                                <span class="font-medium text-gray-500">{{ $message->user->name }}</span>
                                            </div>
                                            <span class="text-gray-500">{{ $message->created_at->format('M j g:ia') }}</span>
                                        </div>
                                        <div class="{{ $message->user->id == 1 ? 'text-teal-700' : 'text-purple-700' }} bg-gray-100 rounded-lg p-4">
                                            <p>{{ Illuminate\Mail\Markdown::parse($message->message) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var messages = document.getElementById("messages");
            messages.scrollTop = messages.scrollHeight;
        });
    </script>
</div>
