<header class="header">
    <div class="header-logo">
        <a class="header-logo__link" href="/">
            <img src="{{ asset('logo/logo.svg') }}" alt="logo" class="header-logo__image">
        </a>
    </div>
    <form class="header-search__form" action="" method="get">
        <input type="text" class="header-search__input" name="keyword" placeholder="なにをお探しですか？" value="{{ old('keyword', $keyword ?? '') }}">
    </form>
    @if (Auth::check())
    <ul class="header-nav">
        <li class="header-nav__item">
            <form action="{{ route('logout') }}" class="header-nav__logout" method="post">
                @csrf
                <button class="header-nav__link">ログアウト</button>
            </form>
        </li>
        <li class="header-nav__item">
            <a href="{{ route('mypage.show') }}" class="header-nav__link">マイページ</a>
        </li>
        <li class="header-nav__item">
            <a href="" class="header-nav__button">出品</a>
        </li>
    </ul>
    @else
    <ul class="header-nav">
        <li class="header-nav__item">
            <a href="{{ route('login') }}" class="header-nav__link">ログイン</a>
        </li>
        <li class="header-nav__item">
            <a href="{{ route('login') }}" class="header-nav__link">マイページ</a>
        </li>
        <li class="header-nav__item">
            <a href="{{ route('login') }}" class="header-nav__button">出品</a>
        </li>
    </ul>
    @endif
</header>