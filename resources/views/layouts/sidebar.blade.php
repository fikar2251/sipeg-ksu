<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{asset('public/asset/images/fotoprofil/default.jpg')}}" width="50" height="55" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
            <div class="email">{{Auth::user()->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <!-- <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profil</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">lock_outline</i>Ganti Password</a></li> -->
                    <li>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button class="btn btn-danger" style="margin-left: 10px;" type="submit" href="javascript:void(0);"><i class="material-icons">input</i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MENU</li>
            <li class="{{(request()->is('/')) ? 'active' : ''}}">
                <a href="{{url('/')}}">
                    <i class="material-icons">home</i>
                    <span>Beranda</span>
                </a>
            </li>
            @can('karyawan')
                
            
            <li @class(['active' => request()->is('karyawanTetap') || request()->is('karyawanKontrak') || request()->is('karyawanTetap/create') ||  request()->is('karyawanTetap/edit/*') || request()->is('karyawanKontrak/edit/*') || request()->is('karyawanKontrak/create') || request()->is('karyawanTidakAktif')]) >
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">accessibility</i>
                    <span>Karyawan</span>
                </a>
                <ul  class="ml-menu">
                    <li @class(['active' => request()->is('karyawanTetap') || request()->is('karyawanTetap/create') || request()->is('karyawanTetap/edit/*')])>
                        <a href="{{route('karyawantetap')}}" >
                            <span>Karyawan Tetap</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('karyawanKontrak') || request()->is('karyawanKontrak/edit/*') || request()->is('karyawanKontrak/create')])>
                        <a href="{{route('karyawankontrak')}}" >
                            <span>Karyawan Kontrak</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('karyawanTidakAktif')])>
                        <a href="{{route('karyawanTidakAktif')}}" >
                            <span>Karyawan Tidak Aktif</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('absensi')
                
            
            <li @class(['active' => request()->is('import') || request()->is('kehadiran') || request()->is('importlembur') ]) >
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_list</i>
                    <span>Absensi</span>
                </a>
                <ul  class="ml-menu">
                    <li @class(['active' => request()->is('import') ])>
                        <a href="{{route('import')}}" >
                            <span>Import Data Absensi</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('importlembur') ])>
                        <a href="{{route('importlembur')}}" >
                            <span>Import Data Absensi Lembur</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('kehadiran')])>
                        <a href="{{route('kehadiran')}}" >
                            <span>Data Kehadiran</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            
            <!-- <li @class(['active' => request()->is('import')]) >
                <a href="{{route('import')}}">
                  <i class="material-icons">file_upload</i>
                  <span>Import Excel</span>
                </a>
              </li> -->
              @can('penggajian')
            <li @class(['active' => request()->is('gajiAll')]) >
                <a href="{{route('gajiAll')}}">
                    <i class="material-icons">attach_money</i>
                    <span>Penggajian</span>
                </a>
            </li>
            @endcan
            @can('pph')  
            <li @class(['active' => request()->is('pph')]) >
                <a href="{{route('pph')}}">
                    <i class="material-icons">attach_money</i>
                    <span>PPH</span>
                </a>
            </li>
            @endcan
            @can('lembur')
                
            
              <li @class(['active' => request()->is('lemburAll') || request()->is('lemburFilter')]) >
                <a href="{{route('lemburAll')}}">
                    <i class="material-icons">monetization_on</i>
                    <span>Lembur</span>
                </a>
            </li>
            @endcan

            @can('slip gaji')
              <li @class(['active' => request()->is('send')]) >
                <a href="{{route('send')}}">
                    <i class="material-icons">poll</i>
                    <span>Slip Gaji</span>
                </a>
            </li>
            @endcan

            @can('user-management')
                
            
            <li @class(['active' => request()->is('roles') || request()->is('permissions') || request()->is('users')]) >
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">accessibility</i>
                    <span>User Management</span>
                </a>
                <ul class="ml-menu">
                    {{-- <li @class(['active' => request()->is('roles')]) >
                        <a href="{{route('roles')}}" >
                            <span>Roles</span>
                        </a>
                    </li> --}}
                    <li @class(['active' => request()->is('permissions')])>
                        <a href="{{route('permissions')}}" >
                            <span>Permissions</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('users')])>
                        <a href="{{route('users')}}" >
                            <span>Users</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
{{-- 
            <li @class(['active' => request()->is('roles') || request()->is('permissions') || request()->is('users')]) >
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">dashboard</i>
                    <span>Master</span>
                </a>
                <ul class="ml-menu">
                    <li @class(['active' => request()->is('roles')]) >
                        <a href="{{route('roles')}}" >
                            <span>Status Karyawan</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('permissions')])>
                        <a href="{{route('permissions')}}" >
                            <span>Jabatan</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('users')])>
                        <a href="{{route('users')}}" >
                            <span>PTKP</span>
                        </a>
                    </li>
                    <li @class(['active' => request()->is('users')])>
                        <a href="{{route('users')}}" >
                            <span>PPH</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
         {{--    <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">widgets</i>
                    <span>Widgets</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Cards</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/cards/basic.html">Basic</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/colored.html">Colored</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/no-header.html">No Header</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Infobox</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/infobox/infobox-1.html">Infobox-1</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-2.html">Infobox-2</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-3.html">Infobox-3</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-4.html">Infobox-4</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-5.html">Infobox-5</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">swap_calls</i>
                    <span>User Interface (UI)</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/ui/alerts.html">Alerts</a>
                    </li>
                    <li>
                        <a href="pages/ui/animations.html">Animations</a>
                    </li>
                    <li>
                        <a href="pages/ui/badges.html">Badges</a>
                    </li>

                    <li>
                        <a href="pages/ui/breadcrumbs.html">Breadcrumbs</a>
                    </li>
                    <li>
                        <a href="pages/ui/buttons.html">Buttons</a>
                    </li>
                    <li>
                        <a href="pages/ui/collapse.html">Collapse</a>
                    </li>
                    <li>
                        <a href="pages/ui/colors.html">Colors</a>
                    </li>
                    <li>
                        <a href="pages/ui/dialogs.html">Dialogs</a>
                    </li>
                    <li>
                        <a href="pages/ui/icons.html">Icons</a>
                    </li>
                    <li>
                        <a href="pages/ui/labels.html">Labels</a>
                    </li>
                    <li>
                        <a href="pages/ui/list-group.html">List Group</a>
                    </li>
                    <li>
                        <a href="pages/ui/media-object.html">Media Object</a>
                    </li>
                    <li>
                        <a href="pages/ui/modals.html">Modals</a>
                    </li>
                    <li>
                        <a href="pages/ui/notifications.html">Notifications</a>
                    </li>
                    <li>
                        <a href="pages/ui/pagination.html">Pagination</a>
                    </li>
                    <li>
                        <a href="pages/ui/preloaders.html">Preloaders</a>
                    </li>
                    <li>
                        <a href="pages/ui/progressbars.html">Progress Bars</a>
                    </li>
                    <li>
                        <a href="pages/ui/range-sliders.html">Range Sliders</a>
                    </li>
                    <li>
                        <a href="pages/ui/sortable-nestable.html">Sortable & Nestable</a>
                    </li>
                    <li>
                        <a href="pages/ui/tabs.html">Tabs</a>
                    </li>
                    <li>
                        <a href="pages/ui/thumbnails.html">Thumbnails</a>
                    </li>
                    <li>
                        <a href="pages/ui/tooltips-popovers.html">Tooltips & Popovers</a>
                    </li>
                    <li>
                        <a href="pages/ui/waves.html">Waves</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assignment</i>
                    <span>Forms</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/forms/basic-form-elements.html">Basic Form Elements</a>
                    </li>
                    <li>
                        <a href="pages/forms/advanced-form-elements.html">Advanced Form Elements</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-examples.html">Form Examples</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-validation.html">Form Validation</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-wizard.html">Form Wizard</a>
                    </li>
                    <li>
                        <a href="pages/forms/editors.html">Editors</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_list</i>
                    <span>Tables</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/tables/normal-tables.html">Normal Tables</a>
                    </li>
                    <li>
                        <a href="pages/tables/jquery-datatable.html">Jquery Datatables</a>
                    </li>
                    <li>
                        <a href="pages/tables/editable-table.html">Editable Tables</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">perm_media</i>
                    <span>Medias</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/medias/image-gallery.html">Image Gallery</a>
                    </li>
                    <li>
                        <a href="pages/medias/carousel.html">Carousel</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">pie_chart</i>
                    <span>Charts</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/charts/morris.html">Morris</a>
                    </li>
                    <li>
                        <a href="pages/charts/flot.html">Flot</a>
                    </li>
                    <li>
                        <a href="pages/charts/chartjs.html">ChartJS</a>
                    </li>
                    <li>
                        <a href="pages/charts/sparkline.html">Sparkline</a>
                    </li>
                    <li>
                        <a href="pages/charts/jquery-knob.html">Jquery Knob</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">content_copy</i>
                    <span>Example Pages</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/examples/sign-in.html">Sign In</a>
                    </li>
                    <li>
                        <a href="pages/examples/sign-up.html">Sign Up</a>
                    </li>
                    <li>
                        <a href="pages/examples/forgot-password.html">Forgot Password</a>
                    </li>
                    <li>
                        <a href="pages/examples/blank.html">Blank Page</a>
                    </li>
                    <li>
                        <a href="pages/examples/404.html">404 - Not Found</a>
                    </li>
                    <li>
                        <a href="pages/examples/500.html">500 - Server Error</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">map</i>
                    <span>Maps</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/maps/google.html">Google Map</a>
                    </li>
                    <li>
                        <a href="pages/maps/yandex.html">YandexMap</a>
                    </li>
                    <li>
                        <a href="pages/maps/jvectormap.html">jVectorMap</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">trending_down</i>
                    <span>Multi Level Menu</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item - 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Level - 2</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);">
                                    <span>Menu Item</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Level - 3</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span>Level - 4</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="pages/changelogs.html">
                    <i class="material-icons">update</i>
                    <span>Changelogs</span>
                </a>
            </li>
            <li class="header">LABELS</li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-red">donut_large</i>
                    <span>Important</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-amber">donut_large</i>
                    <span>Warning</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-light-blue">donut_large</i>
                    <span>Information</span>
                </a>
            </li> --}}
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2023 <a href="javascript:void(0);">PT. Kris Setiabudi Utama</a>.
        </div>
        {{-- <div class="version">
            <b>Version: </b> 1.0.5
        </div> --}}
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
        <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
            <ul class="demo-choose-skin">
                <li data-theme="red" class="active">
                    <div class="red"></div>
                    <span>Red</span>
                </li>
                <li data-theme="pink">
                    <div class="pink"></div>
                    <span>Pink</span>
                </li>
                <li data-theme="purple">
                    <div class="purple"></div>
                    <span>Purple</span>
                </li>
                <li data-theme="deep-purple">
                    <div class="deep-purple"></div>
                    <span>Deep Purple</span>
                </li>
                <li data-theme="indigo">
                    <div class="indigo"></div>
                    <span>Indigo</span>
                </li>
                <li data-theme="blue">
                    <div class="blue"></div>
                    <span>Blue</span>
                </li>
                <li data-theme="light-blue">
                    <div class="light-blue"></div>
                    <span>Light Blue</span>
                </li>
                <li data-theme="cyan">
                    <div class="cyan"></div>
                    <span>Cyan</span>
                </li>
                <li data-theme="teal">
                    <div class="teal"></div>
                    <span>Teal</span>
                </li>
                <li data-theme="green">
                    <div class="green"></div>
                    <span>Green</span>
                </li>
                <li data-theme="light-green">
                    <div class="light-green"></div>
                    <span>Light Green</span>
                </li>
                <li data-theme="lime">
                    <div class="lime"></div>
                    <span>Lime</span>
                </li>
                <li data-theme="yellow">
                    <div class="yellow"></div>
                    <span>Yellow</span>
                </li>
                <li data-theme="amber">
                    <div class="amber"></div>
                    <span>Amber</span>
                </li>
                <li data-theme="orange">
                    <div class="orange"></div>
                    <span>Orange</span>
                </li>
                <li data-theme="deep-orange">
                    <div class="deep-orange"></div>
                    <span>Deep Orange</span>
                </li>
                <li data-theme="brown">
                    <div class="brown"></div>
                    <span>Brown</span>
                </li>
                <li data-theme="grey">
                    <div class="grey"></div>
                    <span>Grey</span>
                </li>
                <li data-theme="blue-grey">
                    <div class="blue-grey"></div>
                    <span>Blue Grey</span>
                </li>
                <li data-theme="black">
                    <div class="black"></div>
                    <span>Black</span>
                </li>
            </ul>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="settings">
            <div class="demo-settings">
                <p>GENERAL SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Report Panel Usage</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Email Redirect</span>
                        <div class="switch">
                            <label><input type="checkbox"><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
                <p>SYSTEM SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Notifications</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Auto Updates</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
                <p>ACCOUNT SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Offline</span>
                        <div class="switch">
                            <label><input type="checkbox"><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Location Permission</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
<!-- #END# Right Sidebar -->