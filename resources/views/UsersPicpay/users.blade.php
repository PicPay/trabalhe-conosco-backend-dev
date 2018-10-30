@extends('layouts.app')

@section('content')
    <div class="container body-background body-tickets">

        <div class="container" id="search-picpay">
            <h1 class="col-sm-8 title-users"> Search Picpay Users </h1>
            <form action="{{ url('/search') }}" method="get">
                <div class="col-sm-4 input-group">
                    <input name="name" type="text" class="form-control" placeholder="Name or Username" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                </span>
                </div>
            </form>
        </div>

        <div class="row table-users">
            <div class="col-lg-12">
                @if($success = session('success'))
                    <div class="alert alert-success">
                        {{ $success}}
                    </div>
                @endif
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Relevance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($usersPicpay) > 0)
                                @foreach($usersPicpay as $userPicpay)
                                    <tr>
                                        <td>
                                            {{ $userPicpay->name }}
                                        </td>
                                        <td>
                                            {{ $userPicpay->username }}
                                        </td>
                                        @if(!empty($userPicpay->relevance))
                                        <td>
                                            {{ $userPicpay->relevance }}
                                        </td>
                                        @else
                                            <td>
                                                Not relevant
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Users not found.</td>
                                </tr>
                            @endif
                            </tbody>
                            @if($usersPicpay->total() > 15)
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="footable-visible">
                                        {{ $usersPicpay->appends(request()->input())->links() }}
                                    </td>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
