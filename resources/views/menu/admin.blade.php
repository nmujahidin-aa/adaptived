<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.student*')) active @endif" href="{{route('admin.student.index')}}">
        <i class="bi-people-fill dropdown-item-icon"></i> Siswa
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.teacher*')) active @endif" href="{{route('admin.teacher.index')}}">
        <i class="bi-mortarboard-fill dropdown-item-icon"></i> Guru
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.variable*')) active @endif" href="{{route('admin.variable.index')}}">
        <i class="bi-clipboard-data-fill dropdown-item-icon"></i> Variabel
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.school*')) active @endif" href="{{route('admin.school.index')}}">
        <i class="bi-hospital-fill dropdown-item-icon"></i> Sekolah
    </a>
</li>