@if(count($errors) > 0)
    <div class="control-group">
        <div class="controls span6">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        </div>
    </div>
@elseif(Session::has('error_message'))
    <div class="control-group">
        <div class="controls span6">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <div class="alert alert-danger" role="alert">
                {!! Session::get('error_message') !!}
            </div>
        </div>
    </div>
@endif
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-white">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg input_field_sections">
                                <h5>ID</h5>
                                <input type="text" name="id" class="form-control rounded_input" value="{{$users->id}}" required>
                            </div>
                            <div class="col-lg input_field_sections">
                                <h5>Nome </h5>
                                <input type="text" name="nome" class="form-control rounded_input" value="{{$users->nome}}"required>
                            </div>
                            <div class="col-md input_field_sections">
                                <h5>User Name </h5>
                                <input type="text" name="username" class="form-control rounded_input" value="{{$users->username}}"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg input_field_sections">
                                <h5>email</h5>
                                <input type="text" name="email" class="form-control rounded_input" value="{{$users->email}}" required>
                            </div>
                            <div class="col-lg input_field_sections">
                                <h5>Prioridade (Quanto mais baixo maior)</h5>
                                <select class="form-control rounded_input" name="priority">
                                    @for($i=0; $i <= $priority; $i++)
                                        <option value="{{$i}}" class="form-control" @if($users->priority == $i) selected @endif> @if($i == 0) {{ $priority+1 }} @else {{ $i }} @endif </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md input_field_sections">
                                <h5>Nova senha</h5>
                                <input type="password" name="password" class="form-control rounded_input">
                            </div>
                        </div>
                        <div class="col-xl-5 col-12-md button_align_top_button_wrap">
                            <span class="button-wrap">
                                <button type="submit" class="button button-pill button-primary">Salvar</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.outer -->
</div>