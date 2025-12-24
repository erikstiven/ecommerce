 <nav class="sticky top-0 z-30 w-full bg-indigo-700 border-b border-indigo-800 shadow-md">
     <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
             <div class="flex items-center justify-start rtl:justify-end">
                <button x-on:click="sidebarOpen = !sidebarOpen" data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <button x-on:click="sidebarCollapsed = !sidebarCollapsed" type="button"
                    class="hidden sm:inline-flex items-center p-2 text-sm text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <span class="sr-only">Toggle sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                 <a class="flex ms-2 md:me-24">
                     <img src="{{ asset('img/logo.png') }}" class="h-8 me-3" alt="Codecima Logo" />
                     <span class="self-center text-xl font-semibold sm:text-xl whitespace-nowrap text-white">
                        Codecima
                     </span>
                 </a>



             </div>
             <div class="flex items-center">
                 <div class="flex items-center ms-3">
                     <x-dropdown align="right" width="48">
                         <x-slot name="trigger">
                             @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                 <button
                                     class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-indigo-300 transition">
                                     <img class="size-8 rounded-full object-cover"
                                         src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                 </button>
                             @else
                                 <span class="inline-flex rounded-md">
                                     <button type="button"
                                         class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-700 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-300 transition ease-in-out duration-150">
                                         {{ Auth::user()->name }}

                                         <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                         </svg>
                                     </button>
                                 </span>
                             @endif
                         </x-slot>

                         <x-slot name="content">
                             <!-- Account Management -->
                             <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('navigation.manage_account') }}
                             </div>

                             <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('navigation.profile') }}
                             </x-dropdown-link>

                             @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                 <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('navigation.api_tokens') }}
                                 </x-dropdown-link>
                             @endif

                             <div class="border-t border-gray-200 dark:border-gray-600"></div>

                             <!-- Authentication -->
                             <form method="POST" action="{{ route('logout') }}" x-data>
                                 @csrf

                                 <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('navigation.log_out') }}
                                 </x-dropdown-link>
                             </form>
                         </x-slot>
                     </x-dropdown>
                 </div>
             </div>
         </div>
     </div>
 </nav>
