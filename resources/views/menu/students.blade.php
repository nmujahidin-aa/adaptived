<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.expertise*')) active @endif" href="">
        <i class="bi-book-half dropdown-item-icon"></i> Kegiatan Belajar
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.expertise*')) active @endif" href="">
        <i class="bi-collection-fill dropdown-item-icon"></i> Sumber Belajar
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('admin.expertise*')) active @endif" href="{{route('assesment.index')}}">
        <i class="bi-collection-fill dropdown-item-icon"></i> Asesmen
    </a>
</li>
