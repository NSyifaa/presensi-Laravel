@php
    $menus = [
        [
            'name' => 'Dashboard',
            'route' => '/',
            'routeName' => '/',
            'icon' => 'fas fa-tachometer-alt'
        ],
        [
            'name' => 'Periode Akademik',
            'route' => '/periode',
            'routeName' => 'periode',
            'icon' => 'fas fa-calendar-alt'
        ],
        [
            'name' => 'Jurusan',
            'route' => '/jurusan',
            'routeName' => 'jurusan',
            'icon' => 'fas fa-university'
        ],
        [
            'name' => 'Data Siswa',
            'route' => 'siswa',
            'routeName' => 'siswa',
            'icon' => 'fas fa-users'
        ],
        [
            'name' => 'Data Guru',
            'route' => '#',
            'routeName' => '',
            'icon' => 'fas fa-user'
        ],
        [
            'name' => 'Mata Pelajaran',
            'route' => '#',
            'routeName' => '',
            'icon' => 'fas fa-book-open'
        ],
        [
            'name' => 'Kelas Mapel',
            'route' => '#',
            'routeName' => '',
            'icon' => 'fas fa-chalkboard-teacher'
        ],
        [
            'name' => 'Presensi',
            'route' => '#',
            'routeName' => '',
            'icon' => 'fas fa-clipboard-check'
        ],
       
    ];
@endphp
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
       
            @foreach ($menus as $menu)
                <li class="nav-item">
                    <a href="{{ $menu['route'] }}" class="nav-link {{ request()->path() == $menu['routeName'] ? 'active' : '' }} ">
                        <i class="nav-icon {{ $menu['icon'] }}"></i>
                        <p>
                            {{ $menu['name'] }}
                        </p>
                    </a>
                </li>
            @endforeach
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>