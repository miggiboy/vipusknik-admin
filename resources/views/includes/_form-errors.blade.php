@if ($errors->any())
    <div class="ui form error">
      <div class="ui error message">
        <div class="header">Допущены следующие ошибки:</div>
        <ul class="list">
          @foreach ($errors->all() as $error )
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <br>
@endif
