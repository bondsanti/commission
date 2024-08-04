{{Form::model($sale ,['route' => ['users.password', $sale->id] , 'method' => 'put'  ])}}

<div class="form-group row">
    {{Form::label('password','รหัสผ่าน', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
    {{Form::password('password', ['class'=>'form-control col-md-7' , 'required' => 'true' , 'minlength' => '6'])}}
</div>
<div class="form-group row">
    {{Form::label('password','ยืนยันรหัสผ่าน', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
    {{Form::password('c_password', ['class'=>'form-control col-md-7', 'required' => 'true' , 'minlength' => '6'])}}
</div>
<div class="form-group row justify-content-center">
    {{Form::submit('เปลี่ยนรหัสผ่าน', ['class' => 'btn btn-primary my-3 '])}}
</div>
{{Form::close()}}
