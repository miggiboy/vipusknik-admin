@extends ('layouts.app')

@section ('title')
  {{ $heading = 'Добавление ' . translate($institutionType, 'r', 's') }}
@endsection

@section ('subnavigation')
    @include ('institutions/partials/_navigation', ['heading' => $heading])
@endsection

@section ('content')

    @include ('includes/_ckeditor')

    <br><br>
    <form action="{{ route('institutions.store', $institutionType) }}"
          method="post"
          class="ui form">

      {{ csrf_field() }}

      <input type="hidden" name="type" value="{{ str_singular($institutionType) }}">

      @include ('includes/_form-errors')

      <div class="ui horizontal divider">
        <i class="teal university icon"></i> Основная информация
      </div>
      <br>

      @include ('institutions/partials/create/_general-fields')

      @include ('institutions/partials/create/_reception_committee_fields')

      <button class="ui big teal button" type="submit">Сохранить</button>
    </form>
    <br><br>

@endsection

@section('script')
  @include ('institutions/partials/_ckeditor-config')
@endsection
