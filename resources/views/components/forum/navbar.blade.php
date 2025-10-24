<nav class="flex items-center justify-between h-16">
                <div>
                    <a href="{{ route('home') }}">
                       <x-forum.logo />
                    </a>
                </div>
                
                <div class="flex gap-4">
                    <a href="#" class="text-sm font-semibold">Foro</a>
                    <a href="#" class="text-sm font-semibold">Blog</a>
                </div>
                
                <div>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900">Log in &rarr;</a>
                </div>
 </nav>