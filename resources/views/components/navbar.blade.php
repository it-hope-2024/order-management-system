<header class="z-40 bg-gray-100">
    <nav>
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">

                <img src="{{ asset('assets/images/product.svg') }}" class="h-8" alt= "Logo" />
                <span class="self-center text-xl font-semibold whitespace-nowrap text-gray-600">
                    {{ __('messages.site') }}</span>
            </a>
            <button data-collapse-toggle="navbar-solid-bg" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm bg-gray-300 text-gray-100 rounded-lg md:hidden hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400  "
                aria-controls="navbar-solid-bg" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul
                    class="flex flex-col font-medium mt-4 rounded-lg  md:space-x-4 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 text-gray-600 ">

                    <li>
                        <a href="{{ route('home') }}"
                            class=" block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white ">{{ __('messages.home') }}</a>
                    </li>


                    @if (Route::has('login'))

                        @auth
                            <li>
                                <a href="{{ url('/dashboard') }}"
                                    class="block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    {{ __('messages.dashboard') }}
                                </a>
                            </li>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('management') }}"
                                    class="block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    {{ __('messages.management') }}
                                </a>
                            @endif

                            <li>
                                <a href="{{ route('orders.my-orders') }}" class="relative">
                                    <button class="text-white bg-gray-700 px-3 py-2 rounded-lg">
                                        {{ __('messages.my-orders') }}
                                    </button>
                                    <span id="cart-count"
                                        class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ Auth::user()->orders()->where('status', 'pending')->join('order_items', 'orders.id', '=', 'order_items.order_id')->sum('order_items.quantity') ?? 0 }}
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('orders.my-purchases') }}" class="relative">
                                    <button class="text-white bg-gray-700 px-3 py-2 rounded-lg">
                                        {{ __('messages.my-purchases') }}
                                    </button>
                                    <span id="cart-count"
                                        class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ Auth::user()->orders()->where('status', 'completed')->join('order_items', 'orders.id', '=', 'order_items.order_id')->sum('order_items.quantity') ?? 0 }}

                                    </span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                    class="block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    {{ __('messages.login') }}
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}"
                                        class="block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        {{ __('messages.register') }}
                                    </a>
                                </li>
                            @endif
                        @endauth

                    @endif

                    @auth


                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button
                                    class="block rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" x2="9" y1="12" y2="12" />
                                    </svg></button>
                            </form>

                        </li>
                    @endauth


                    <li>
                        <div class="relative inline-block text-left">
                            <button id="dropdownButton" data-dropdown-toggle="languageDropdown"
                                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('messages.language') }}:{{ LaravelLocalization::getCurrentLocaleNative() }}

                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="languageDropdown"
                                class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton"
                                tabindex="-1">
                                <div class="py-1" role="none">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">
                                            {{ $properties['native'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @auth
                        @if (auth()->user()->is_admin)
                            <li class="relative">
                                <button id="notifications-btn" class="relative">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span id="notification-count"
                                        class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1 hidden">
                                        0
                                    </span>
                                </button>

                                <div id="notification-dropdown"
                                    class="absolute right-0 mt-2 w-64 bg-white border rounded shadow-lg hidden">
                                    <div id="notification-list" class="p-2 text-gray-500">Checking ...</div>
                                </div>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

</header>


<script>
    window.IsAdmin = @json(auth()->check() ? auth()->user()->is_admin : false);

 

    document.addEventListener("DOMContentLoaded", function () {
    // Check if user is admin before fetching notifications
    if (!window.IsAdmin) {
        console.log("User is not an admin. Skipping notification fetch.");
        return;
    }

    function fetchNotifications() {
        fetch('/notifications', {
            method: 'GET',
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(response => {
            if (!response.ok) throw new Error("Failed to fetch notifications.");
            return response.json();
        })
        .then(data => {
            let notificationList = document.getElementById("notification-list");
            let notificationCount = document.getElementById("notification-count");

            if (!notificationList || !notificationCount) {
                console.error("Notification elements not found.");
                return;
            }

            notificationList.innerHTML = "";

            if (data.length === 0) {
                notificationList.innerHTML = '<div class="p-2 text-gray-500">No Notifications</div>';
                notificationCount.classList.add("hidden");
            } else {
                notificationCount.classList.remove("hidden");
                notificationCount.innerText = data.length;

                data.forEach(notification => {
                    let notificationItem = document.createElement("div");
                    notificationItem.classList.add("p-2", "border-b");
                    notificationItem.textContent = notification.data.message;
                    notificationList.appendChild(notificationItem);
                });
            }
        })
        .catch(error => console.error("Error In Extracting Notifications:", error));
    }

    fetchNotifications();

    let notificationsBtn = document.getElementById("notifications-btn");
    let notificationDropdown = document.getElementById("notification-dropdown");
    let notificationCount = document.getElementById("notification-count");

    if (notificationsBtn && notificationDropdown && notificationCount) {
        notificationsBtn.addEventListener("click", function () {
            notificationDropdown.classList.toggle("hidden");

            if (!notificationDropdown.classList.contains("hidden")) {
                notificationCount.classList.add("hidden");

                fetch('/notifications/mark-as-read', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                }).catch(error => console.error("Error In Updating Notifications", error));
            }
        });
    } else {
        console.error("Notification button or dropdown elements not found.");
    }
});

</script>
