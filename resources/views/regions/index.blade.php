@extends ('layouts.app')

@section ('title', 'Области')

@section ('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/utilities.min.css">
@endsection

@section ('content')
    <div class="flex">
        <div class="w-1/2">
            <form action="{{ route('regions.store') }}" method="post">
                {{ csrf_field() }}

                <input type="text" class="block w-1/2" required name="name" placeholder="Название (именительный падеж)">
                <input type="text" class="block w-1/2" required name="name_genitive" placeholder="Название (родительный падеж)">

                <button type="submit" class="block">
                    Добавить область
                </button>
            </form>

            @foreach ($regions as $region)
                <div class="mb-6">
                    <h4 class="text-xl mb-2">{{ $region->name }}</h4>
                    <div>
                        <h4 class="mb-0">Города:</h4>
                        @foreach ($region->cities as $city)
                            <div>
                                {{ $city->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-1/2">
            <form action="{{ route('cities.store') }}" method="post">
                {{ csrf_field() }}

                <input type="text" name="title" placeholder="Название (именительный падеж)">
                <input type="text" name="title_coginitive" placeholder="Название (родительный падеж)">

                <select name="region_id">
                    <option value="">Область</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit">
                    Добавить город
                </button>
            </form>

            @foreach ($cities as $city)
                <div class="mb-6">
                    {{ $city->title }}
                    <div>
                        <form action="/cities/{{ $city->id }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <select name="region_id" onchange="this.form.submit()">
                                <option value="">Область</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}" {{ $region->id == $city->region_id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
