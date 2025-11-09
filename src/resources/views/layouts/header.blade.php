<header class="header">
    <div class="header-logo">
        <a class="header-logo__link" href="/">
            <img src="{{ asset('logo/logo.svg') }}" alt="logo" class="header-logo__image">
        </a>
    </div>
    @if (Auth::check())
    <form class="header-search__form" action="" method="get">
        <input type="text" class="header-search__input" placeholder="なにをお探しですか？" value="{{ old('search') }}">
    </form>
    <ul class="header-nav">
        <li class="header-nav__item">
            <form action="{{ route('logout') }}" class="header-nav__logout" method="post">
                @csrf
                <button class="header-nav__link">ログアウト</button>
            </form>
        </li>
        <li class="header-nav__item">
            <a href="{{ route('mypage.show')}}" class="header-nav__link">マイページ</a>
        </li>
        <li class="header-nav__item">
            <a href="{{ route('item.create') }}" class="header-nav__button">出品</a>
        </li>
    </ul>
    @endif
</header>