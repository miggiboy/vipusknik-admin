<div class="ui medium menu" style="display: flex !important; margin-bottom: 40px;">
<!--top fixed -->
<div class="ui container">
    @if (Auth::user()->isInTeam())
      <a href="{{ route('home') }}" class="item">
        <img src="/images/logo.png" alt="Главная" class="logo">
      </a>


      <a href="{{ route('institutions.index', 'universities') }}" class="item">Университеты </a>
      <a href="{{ route('institutions.index', 'colleges') }}" class="item">Колледжи </a>

      <div class="ui dropdown item">
        Специальности <i class="dropdown icon"></i>
        <div class="menu" style="font-size: 14px;">
            <a href="{{ route('specialties.index', 'university') }}" title="Специальности университетов" class="item">
              Универстетов
            </a>
            <a href="{{ route('specialties.index', 'college') }}" title="Специальности колледжей" class="item">
              Колледжей
            </a>
            <div class="ui divider"></div>
            <a href="{{ route('qualifications.index') }}" title="Квалификации колледжей" class="item">
              Квалификации
            </a>
        </div>
      </div>

      <a href="{{ route('professions.index') }}" class="item">Профессии </a>
      <a href="{{ route('articles.index') }}" class="item">Статьи </a>

      <div class="ui dropdown item">
        Предметы <i class="dropdown icon"></i>
        <div class="menu" style="font-size: 14px;">
            <a href="{{ route('subjects.index') }}" class="item">Предметы </a>
            <a href="{{ route('quizzes.index') }}" class="item">Тесты </a>
        </div>
      </div>

      <div class="ui dropdown item">
        Еще <i class="dropdown icon"></i>
        <div class="menu" style="font-size: 14px;">
            <a href="{{ route('cities.index') }}" class="item">Города </a>
        <a href="{{ route('regions.index') }}" class="item">Области </a>
        </div>
      </div>
    @endif
  <div class="right menu">

    @if (Auth::check())

      <div class="ui floating dropdown link item">
        <div class="text">
          <img class="logo" src="{{ auth()->user()->avatar_path }}">
          {{ str_limit(auth()->user()->nameOrUsername, 15) }}
        </div>
        <i class="dropdown icon"></i>

        <div class="menu">

          <a href="{{ route('profile.show') }}" class="item">
             <i class="teal user icon"></i> Мой профиль
          </a>
         @if (Auth::user()->isInTeam())
          @role ('admin' || 'developer')
            <a href="{{ route('team-members.index') }}" class="item">
               <i class="teal users icon"></i> Команда сайта
            </a>
            <div class="ui divider"></div>
          @endrole
        @endif
            <a href="{{ route('clients.index') }}" class="item">
               <i class="teal users icon"></i> Клиенты
            </a>
            <div class="ui divider"></div>
          <a href="{{ route('logout') }}" class="item">
            <i class="teal sign out icon"></i> Выход
          </a>
        </div>
      </div>


    @else
      <a href="{{ route('login') }}" class="item">Вход</a>
      <a href="{{ route('registration.create') }}" class="item">Регистрация</a>
    @endif

  </div>
</div>
</div>
