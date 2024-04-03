<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == 'wpaccount.edit' ? 'active' : null}}" aria-current="page" href="{{route('wpaccount.edit', ['id' => $wpaccount])}}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName() == 'wpnumber.index' ? 'active' : null}}" href="{{route('wpnumber.index', ['id' => $wpaccount])}}">Numbers</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == 'wpmessagetemplate.index' ? 'active' : null}}" href="{{route('wpmessagetemplate.index', ['id' => $wpaccount])}}">Message Templates</a>
    </li>
</ul>
<br>
