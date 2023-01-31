<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="aplikasi bengkel shop">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="author" content="">
    <link href="{{ URL::asset('assets/ruangAdmin/img/logo/logo.png') }}" rel="icon">
    <title>MMTop Bakery || Daftar</title>
    <link href="{{ URL::asset('assets/ruangAdmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/ruangAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/ruangAdmin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
</head>

<body class="bg-gradient-login">
    <!-- Register Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form id="formRegister" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Nama</label>
                                                    <input type="type" name="nama" id="name" class="form-control">
                                                    <small id="error-nama" class="text-danger">

                                                    </small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control">
                                                    <small id="error-email" class="text-danger">

                                                    </small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control" minlength="6">
                                                    <small id="error-password" class="text-danger">

                                                    </small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password_confirmation">Comfirm Password</label>
                                                    <input type="password" id="password_confirmation"
                                                        name="password_confirmation" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="avatar">Avatar</label>
                                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                                    <small id="error-avatar" class="text-danger">

                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="{{ route('login') }}">Already have an
                                            account?</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- jquery -->
<script src="{{ URL::asset('assets/ruangAdmin/vendor/jquery/jquery.min.js') }}"></script>
<!-- sweetalert -->
<script src="{{ URL::asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ URL::asset('assets/select2/js/select2.min.js') }}"></script>
<script>
    window.onload = function() {
        console.log('tunggu');
    }
    $(document).ready(function() {
        $('#provinsi').select2({
            placeholder: "--Pilih Provinsi--",
            allowClear: true
        });
        $('#kabupaten').select2({
            placeholder: "--Pilih Kabupaten/Kota--",
            allowClear: true
        });
        $('#kecamatan').select2({
            placeholder: "--Pilih Kecamatan--",
            allowClear: true
        });
    })
    const form = document.getElementById('formRegister');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        let data = new FormData(document.querySelector('#formRegister'));

        const email = document.getElementById('email').value;
        const validasiEmail = await checkEmai(email);
        if (validasiEmail) {
            Swal.fire(
                'Warning...!',
                'Email Anda Sudah Ter Daftar',
                'warning'
            )
            return false;
        }
        const result = await postData(data);
    })

    async function checkEmai(email) {
        const sendRequest = await fetch('/register', {
            method: "POST",
            body: JSON.stringify({
                email,
                checkEmail: true
            }),
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            }
        })
        const result = await sendRequest.json();
        return result;
    }

    async function postData(data) {
        try {
            const sendRequest = await fetch('/register', {
                method: "POST",
                body: data,
                headers: {
                    'Accept': 'application/json'
                }
            })
            const result = await sendRequest.json();
            if (!result.errors) {
                if (result == true) {
                    // console.log(result);
                    Swal.fire(
                        'sukses...!',
                        'Anda Sukses Registrasi',
                        'success'
                    ).then(() => {
                        document.location.href = '/';
                    });
                } else {
                    Swal.fire(
                        'error...!',
                        'Ada Kesalahan Pas Registrasi',
                        'error'
                    )
                }
            } else {
                console.log(result);
                const resultArray = Object.values(result.errors);
                document.getElementById(`error-nama`).innerHTML = ``
                document.getElementById(`error-email`).innerHTML = ``
                document.getElementById(`error-password`).innerHTML = ``
                document.getElementById(`error-avatar`).innerHTML = ``
                document.getElementById(`error-provinsi`).innerHTML = ``
                document.getElementById(`error-kecamatan`).innerHTML = ``
                document.getElementById(`error-kabupaten`).innerHTML = ``
                document.getElementById(`error-kode`).innerHTML = ``
                document.getElementById(`error-nomer`).innerHTML = ``
                document.getElementById(`error-jenis`).innerHTML = ``
                resultArray.map(data => {
                    const filedId = data[0].split(' ')[1];
                    document.getElementById(`error-${filedId}`).innerHTML = data[0];
                })
            }
        } catch (error) {
            Swal.fire(
                'error...!',
                'Ada Kesalahan Pas Registrasi',
                'error'
            )
        }
    }

</script>

</html>
