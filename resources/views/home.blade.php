@extends('layouts.app')

@section('content')
    <div class="container">
        <a id="items-list" href="#/items-list" style="display: none;">Item</a>
        <div class="row justify-content-center">
            <input type="hidden" id="token-user" value="{{ $token }}">
            <div class="container">
                <ng-view></ng-view>
            </div>
        </div>

    </div>
@endsection

<script>
    window.onload = function(){
        document.getElementById("items-list").click();
    }
</script>