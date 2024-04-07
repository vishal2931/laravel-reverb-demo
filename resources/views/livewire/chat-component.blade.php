<form wire:submit="sendMessage">
    <div class="max-w-6xl mx-auto my-10 bg-white rounded-lg shadow-lg" x-init="scroll = document.getElementById('chat-container'); scroll.scrollTop = scroll.scrollHeight;">
        <div class="flex justify-between items-center px-6 py-4 bg-gray-200 rounded-t-lg">
            <h1 class="text-lg font-bold">A place to talk</h1>
        </div>
        <div class="px-6 py-4 max-h-[250px] overflow-y-scroll" id="chat-container" x-ref="chatContainer">
            @foreach ($messages as $messageItem)
                <div @class([
                    'flex space-x-4 mb-4',
                    'items-start justify-start' => $messageItem['user_id'] != auth()->id(),
                    'items-end justify-end' => $messageItem['user_id'] == auth()->id(),
                ])>
                    @if (auth()->id() != $messageItem['user_id'])
                        <img src="https://gravatar.com/avatar/{{ md5($messageItem['user']['email']) }}?s=400&d=robohash&r=x"
                            alt="User Avatar" class="w-8 h-8 rounded-full">
                    @endif
                    <div @class([
                        'px-4 py-2 rounded-lg',
                        'bg-gray-200' => $messageItem['user_id'] != auth()->id(),
                        'bg-blue-500' => $messageItem['user_id'] == auth()->id(),
                    ])>
                        <p @class([
                            'text-sm',
                            'text-gray-800' => $messageItem['user_id'] != auth()->id(),
                            'text-white' => $messageItem['user_id'] == auth()->id(),
                        ])>{{ $messageItem['message'] }}</p>
                    </div>
                    @if (auth()->id() == $messageItem['user_id'])
                        <img src="https://gravatar.com/avatar/{{ md5($messageItem['user']['email']) }}?s=400&d=robohash&r=x"
                            alt="User Avatar" class="w-8 h-8 rounded-full">
                    @endif
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-between px-6 py-4 bg-gray-200 rounded-b-lg">
            <input type="text" placeholder="Type a message..."
                class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
                wire:model='message' required>
            <button class="px-4 py-2 ml-3 text-sm text-white bg-blue-500 rounded-md focus:outline-none"
                type="submit">Send</button>
        </div>
    </div>
    @script
        <script>
            Echo.channel('chat-channel')
            .listen('SendMessageEvent', e => {
                setTimeout(() => {
                    let container = document.getElementById('chat-container');
                    container.scrollTop = container.scrollHeight;
                }, 300);
            })
        </script>
        
    @endscript
</form>
