@extends ('layouts.app')

@section ('title', 'Области')

@section ('content')
    <form action="{{ route('regions.store') }}" method="post">
        {{ csrf_field() }}

        <input type="hidden" value="">

        <input type="text" name="name" placeholder="Название">

        <button type="submit">
            Добавить
        </button>
    </form>

    @foreach ($regions as $region)
        {{ $region->name }}
    @endforeach
@endsection
