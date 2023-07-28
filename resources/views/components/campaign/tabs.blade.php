<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link {{Route::currentRouteName() == 'campaign.edit' ? 'active' : null}}" aria-current="page" href="{{route('campaign.edit', ['id' => $campaign])}}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName() == 'campaign.process' ? 'active' : null}}" href="{{route('campaign.process', ['id' => $campaign])}}">Process</a>
    </li>
</ul>
<br>