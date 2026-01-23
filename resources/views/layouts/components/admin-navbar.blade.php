<div class="sa-toolbar sa-toolbar--search-hidden sa-app__toolbar">
    <div class="sa-toolbar__body">

        <div class="sa-toolbar__item">
            <button class="sa-toolbar__button" type="button" aria-label="Menu" data-sa-toggle-sidebar="">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M1,11V9h18v2H1z M1,3h18v2H1V3z M15,17H1v-2h14V17z"></path>
                </svg>
            </button>
        </div>

        <div class="mx-auto sa-toolbar__item headerfix1">{{ $page_title ?? 'Sin título' }}</div>

        <div class="dropdown sa-toolbar__item">
            <button class="sa-toolbar-user" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-offset="0,1"
                aria-expanded="false">
                <span class="sa-toolbar-user__avatar sa-symbol sa-symbol--shape--rounded">
                    <img src="{{asset('images/default-profile.jpg')}}" alt="" width="64" height="64"></span>
                    <span class="sa-toolbar-user__info"><span class="sa-toolbar-user__title">
                        {{session()->get('user_cur_fullname')}}
                    </span>
                    <span class="sa-toolbar-user__subtitle">
                        {{session()->get('email_cur_user')}}
                    </span>
                    
                </span>
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton" style="">
                <!-- <li><a class="dropdown-item" href="#">Profile</a></li> -->
                <!-- <li>
                    <hr class="dropdown-divider">
                </li> -->
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>                        
                    </a>
                </li>
            </ul>
        </div>        

    </div>
    <div class="sa-toolbar__shadow"></div>
</div>