@extends ('layouts.app')

@section ('title')
    Связанные уч. зазведения
@endsection

@section ('content')
    <form action="{{ route('related-institutions.store', $institution) }}" method="post">
        <h3>
            {{ $institution->title }}, связанные учебные заведения
        </h3>

        {{ csrf_field() }}

        <select
            name="related_institutions[]"
            class="ui fluid search dropdown"
            multiple
        >
            <option value="">Учебное заведение</option>
            @foreach ($institutions as $institution)
                <option value="{{ $institution->id }}">
                    {{ $institution->title }}
                </option>
            @endforeach
        </select>

        <br>

        <button type="submit">
            Сохранить
        </button>
    </form>
@endsection
