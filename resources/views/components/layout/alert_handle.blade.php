@if(session('success'))
<x-layout.alert status="Success" message="{{session('success')}}" class="success" />
@endif

@if(session('error'))
<x-layout.alert status="Error" message="{{session('error')}}" class="error" />
@endif