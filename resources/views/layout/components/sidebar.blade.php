@php
    $menus = [
        [
            'name' => 'Dashboard',
            'route' => '/dashboard',
            'routeName' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt'
        ],
        [
            'name' => 'Tahun Ajaran',
            'route' => '/periode',
            'routeName' => 'periode',
            'icon' => 'fas fa-calendar-alt'
        ],
        [
            'name' => 'Mata Pelajaran',
            'route' => '/mapel',
            'routeName' => 'mapel',
            'icon' => 'fas fa-book-open'
        ],
        [
            'name' => 'Jurusan',
            'route' => '/jurusan',
            'routeName' => 'jurusan',
            'icon' => 'fas fa-university'
        ],
        [
            'name' => 'Kelas Jurusan',
            'route' => '/kelas_jurusan',
            'routeName' => 'kelas_jurusan',
            'icon' => 'fas fa-chalkboard'
        ],
        [
            'name' => 'Data Siswa',
            'route' => '/siswa',
            'routeName' => 'siswa',
            'icon' => 'fas fa-users'
        ],
        [
            'name' => 'Data Guru',
            'route' => '/guru',
            'routeName' => 'guru',
            'icon' => 'fas fa-user-tie'
        ],
        [
            'name' => 'KBM',
            'route' => '/kbm',
            'routeName' => 'kbm',
            'icon' => 'fas fa-chalkboard-teacher'
        ],
        [
            'name' => 'Presensi',
            'route' => '#',
            'routeName' => '',
            'icon' => 'fas fa-clipboard-check'
        ],
        [
            'name' => 'Keluar',
            'route' => '/logout',   
            'routeName' => '',
            'icon' => 'fas fa-sign-out-alt'
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
                    <a href="{{ $menu['route'] }}" class="nav-link {{ request()->is(ltrim($menu['route'], '/') . '*') ? 'active' : '' }}">
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