<!-- Dashboards -->
<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('superadmin.student*')) active @endif" href="{{route('superadmin.student.index')}}">
        <i class="bi-people-fill dropdown-item-icon"></i> Siswa
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('superadmin.student*')) active @endif" href="{{route('superadmin.student.index')}}">
        <i class="bi-person-hearts dropdown-item-icon"></i> Guru
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('superadmin.student*')) active @endif" href="{{route('superadmin.student.index')}}">
        <i class="bi-bank2 dropdown-item-icon"></i> Sekolah
    </a>
</li>

