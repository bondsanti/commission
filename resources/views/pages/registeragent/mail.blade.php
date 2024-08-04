<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Congratulations</title>
</head>
<body>
    <h2>ยินดีต้อนรับ คุณ {{$users->name_th}}</h2>
    <h4>ขอขอบคุณ คุณ{{$users->name_th}} ที่สนใจเข้าสมัครเป็นตัวแทนอสังหาริมทรัพย์กับทาง V Beyond Developments Public Co.,Ltd.</h4>
    <h4>คุณได้ทำการสมัครสมาชิก ผ่านการฝึกอบรมและเซ็นสัญญาเรียบร้อย</h4>
    <h4>ออกบัตรตัวแทนให้แก่ท่านในลำดับต่อไป</h4>
    {{-- <h4>เพื่อเชิญคุณ{{$users->name_th}} เข้ารับการอบรมและเซ็นสัญญา</h4> --}}
    {{-- <h4>ขอบคุณที่ท่านไว้วางใจเราและเราจะพาคุณเติบโตไปด้วยกัน ขอบคุณครับ/ค่ะ</h4> --}}
    {{-- <h4>CodeAgent : {{$users->code}}</h4> --}}
    {{-- <h4>Team : {{$teams->name}}</h4> --}}
    <h4>User : {{$users->code}}</h4>
    <h4>Password : {{$Pass}} </h4>
    <h5>*สามารถเปลี่ยนรหัสผ่านใหม่ได้ในระบบ</h5>

    <h2><a href="{{$Link}}"> เข้าสู่ระบบ </a></h2>

</body>
</html>
