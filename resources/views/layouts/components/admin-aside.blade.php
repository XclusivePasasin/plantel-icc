<div class="sa-app__sidebar">
    <div class="sa-sidebar">
        <div class="sa-sidebar__header">
        <a class="sa-sidebar__logo" href="index.html">
            <!-- logo -->
            <div class="sa-sidebar-logo">
                <img style="display: block;width: 100%;" src="{{asset('images/logo-icc.png')}}" alt="">
            </div>
            <!-- logo / end -->
        </a>
        </div>
        <div class="sa-sidebar__body" data-simplebar="init">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                            <div class="simplebar-content" style="padding: 0px;">
                                <ul class="sa-nav sa-nav--sidebar" data-sa-collapse="">
                                    <li class="sa-nav__section">
                                        <div class="sa-nav__section-title"><span>Application</span></div>
                                        <ul class="sa-nav__menu sa-nav__menu--root">
                                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                                <a href="{{route('admin.home',['page_pass' => 'Panel Principal'])}}" class="sa-nav__link">
                                                    <span class="sa-nav__icon"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                                                    <span class="sa-nav__title">Inicio</span>
                                                </a>
                                            </li>  

                                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                                <a href="{{route('mix.status',['page_pass' => 'Estados mezcla'])}}" class="sa-nav__link">
                                                    <span class="sa-nav__icon"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                                                    <span class="sa-nav__title">Estados mezcla</span>
                                                </a>
                                            </li>      
                                            
                                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                                <a href="{{route('packing.status',['page_pass' => 'Estados empaque'])}}" class="sa-nav__link">
                                                    <span class="sa-nav__icon"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                                                    <span class="sa-nav__title">Estados empaque</span>
                                                </a>
                                            </li>                                               

                                            @foreach(Session::get('main_menu') as $ite_menu)
                                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                                <a href="{{route($ite_menu->path,['page_pass' => $ite_menu->menu])}}" class="sa-nav__link">
                                                    <span class="sa-nav__icon"><i class="{{$ite_menu->icon}}"></i></span>
                                                    <span class="sa-nav__title">{{$ite_menu->menu}}</span>
                                                </a>
                                            </li>                                             
                                            @endforeach

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 935px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"></div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;"></div>
        </div>
    </div>
</div>