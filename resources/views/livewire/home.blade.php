<style>
    h1 {
        margin: 1.5rem;
    }
</style>

<div>
    @if(auth()->guest())
        <div class="container flex flex-col items-center justify-center space-y-12 m-auto min-h-screen p-4">
            <div class="space-y-1 text-center">
                <h1 class="text-4xl text-teal-100">What is this Life?</h1>
                <h2 class="text-teal-100">What is this, Life?</h2>
                <h3 class="text-teal-100">What, is this Life?</h3>
            </div>

            <div class="flex flex-col bg-white text-teal-600 rounded-lg shadow space-y-4 p-8">
                <p>If this is Maggie, you'll know the secret password :)</p>

                <input wire:keydown.enter="login()" wire:model="password" type="password" class="border rounded p-2">

                <button wire:click="login" class="bg-teal-500 text-white rounded-lg shadow px-4 py-2">Login</button>
                @error('login') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
        </div>
    @else
        <button wire:click="logout" class="bg-teal-200 text-teal-600 rounded px-4 py-2 m-4">Logout</button>

        <div style="max-width: 800px;" class="container flex flex-col space-y-4 w-full mt-16 m-auto pb-12">
            <div>
                <p class="text-sm text-teal-200">- To add a line break, simply put a "#" in a line.</p>
                <p class="text-sm text-teal-200">- To expand the textarea, drag the symbol at the bottom right.</p>
            </div>

            <div class="bg-teal-200 rounded-lg p-4">
                <textarea wire:model="message" tabindex="1"
                    placeholder="Write your message here..."
                    class="p-2 bg-transparent placeholder-teal-500 text-teal-800 border-none shadow-none outline-none w-full"
                    rows="10"
                ></textarea>

                <span wire:click="saveMessage()"
                    class="block bg-teal-300 text-teal-800 text-center rounded cursor-pointer px-4 py-2 w-full hover:bg-teal-400"
                >Save</span>
            </div>

            <ul class="bg-white list list-inside rounded-lg divide-y space-y-4 p-6">
                @foreach($this->messages as $message)
                    <li>
                        <div class="{{ $loop->first ? '' : 'pt-4' }}">
                            <div class="flex {{ $message->user->id == 1 ? 'justify-end' : 'justify-start' }} items-start space-x-3">
                                <div class="flex flex-col w-3/4 {{ $message->user->id == 1 ? 'items-end' : 'items-start' }}">
                                    <div class="flex items-center text-xs space-x-2">
                                        <p class="font-medium text-gray-500">{{ $message->user->name }}</p>
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
    @endif
</div>
