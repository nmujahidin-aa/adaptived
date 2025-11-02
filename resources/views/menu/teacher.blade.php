<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('teacher.student*')) active @endif" href="{{route('teacher.student.index')}}">
        <i class="bi-people-fill dropdown-item-icon"></i> Siswa
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('teacher.learning-resource*')) active @endif" href="{{route('teacher.learning-resource.index')}}">
        <i class="bi-book-fill dropdown-item-icon"></i> Sumber Belajar
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('teacher.worksheet*')) active @endif" href="{{route('teacher.worksheet.index')}}">
        <i class="bi-laptop-fill dropdown-item-icon"></i> LKPD
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('teacher.group*')) active @endif" href="{{route('teacher.group.index')}}">
        <i class="bi-unity dropdown-item-icon"></i> Kelompok Belajar
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('teacher.assesment*')) @elseif(request()->routeIs('teacher.answer*')) active @endif" href="{{route('teacher.assesment.index')}}">
        <i class="bi-collection-fill dropdown-item-icon"></i> Asesmen
    </a>
</li>
