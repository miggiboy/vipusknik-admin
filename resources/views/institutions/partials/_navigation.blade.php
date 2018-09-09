<div class="ui twelve column left aligned very relaxed grid" style = "position: relative;">

  @if (isset($custom_heading_layout))
    {{ $custom_heading_layout }}
  @else
    <div class="nine wide column">
      <h1>{{ $heading }}</h1>
    </div>
  @endif
 
    @if (Auth::user()->isInTeam())
      <div class="four wide column" style="position: absolute; top: -2px; right: -10px;">
        <div class="ui compact small menu">
          <a class="item" href="{{ route('institutions.index', $institutionType) }}">
            <i class="teal university icon"></i>
            {{ translate($institutionType, 'i', 'p', true) }}
          </a>
    
          <a class="item" href="{{ route('institutions.create', $institutionType) }}">
            <i class="teal circle add icon"></i> Добавить
          </a>
        </div>
      </div>
    
    @endif

</div>

<br><br>