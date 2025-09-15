<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('learning-resource.*')) active @endif" href="{{route('learning-resource.index')}}">
        <i class="bi-book-half dropdown-item-icon"></i> Sumber Belajar
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('worksheet.*')) active @endif" href="{{route('worksheet.index')}}">
        <i class="bi-collection-fill dropdown-item-icon"></i> LKPD
    </a>
</li>

<li class="nav-item">
    <a class="nav-link @if(request()->routeIs('assesment.*')) active @endif" href="{{route('assesment.index')}}">
        <i class="bi-collection-fill dropdown-item-icon"></i> Asesmen
    </a>
</li>
