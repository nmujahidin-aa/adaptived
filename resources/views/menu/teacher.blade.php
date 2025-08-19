<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('superadmin.student*')) active @endif" href="#">
        <i class="bi-people-fill dropdown-item-icon"></i> Siswa
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.expertise*')) active @endif" href="#">
        <i class="bi-collection-fill dropdown-item-icon"></i> Materi
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.assessment*')) active @endif" href="{{route('teacher.assesment.index')}}">
        <i class="bi-collection-fill dropdown-item-icon"></i> Asesmen
    </a>
</li>
