<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>LinkRegis</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-6 col-lg-6 mx-auto">
                <img class="rounded mx-auto d-block" src="{{ asset('/images/vbe.png') }}" alt="" width="280">
                <div class="card border-0 shadow rounded-3">
                    <div class="card-body">
                        <h4>ลิงค์สมัครสมาชิกทีม Agent ของคุณ</h4>
                        <form action="">

                            
                                <div class="form-group row">
                              
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-danger" placeholder="regis/{code}/{id}" id="link" value="{{url('regis/'.$users->id)}}"  readonly>
                                        
                                    </div>
                                    <div class="col-sm-2">
                                    <button type="button" class="btn btn-outline-primary" onclick="copyLink()">Copy</button>
                                    </div>
                 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function copyLink() {
      const linkField = document.getElementById("link");
      linkField.select();
      document.execCommand("copy");
      Swal.fire({
        icon: 'success',
        title: 'Link Copied',
        text: 'Link copied to clipboard',
      });
    }
</script>
<style>
    body {
        background: linear-gradient(to left, #facd93 10%, #f9ece0 100%);
    }

    .btn-login {

        background: linear-gradient(to right, #facd93, #f79b46);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,
    Safari 7+ */
        color: #fff;
        /* border: 3px solid #eee; */
    }
</style>
