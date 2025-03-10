@extends('layouts.app', ['pageSlug' => 'inputticket'])

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <p>Input Ticket</p>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Start typing a name..." required autocomplete="off">
                                <div id="nameList" class="autocomplete-list"></div>
                            </div>

                            <div class="form-group">
                                <label for="division">Division</label>
                                <input type="text" class="form-control" id="division" name="division" placeholder="Division" readonly>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <label for="message">Description</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Enter your message here" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <!-- Generated Message Section -->
                        <div id="generatedMessage" class="mt-4" style="display: none; ">
                            <h5>Generated Message:</h5>
                            <pre id="messageContent" style="white-space: pre-wrap; background: #0d5094; padding: 10px; border-radius: 5px;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    .autocomplete-list {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
    }

    .autocomplete-item:hover {
        background: #023449;
    }
</style>

<script>
$(document).ready(function () {
    $('#name').on('input', function () {
        let query = $(this).val();

        if (query.length > 2) {
            $.ajax({
                url: "{{ route('autocomplete.employees') }}",
                type: "GET",
                data: { query: query },
                success: function (data) {
                    let nameList = $('#nameList');
                    nameList.empty();

                    if (data.length > 0) {
                        nameList.show();
                        data.forEach(function (employee) {
                            nameList.append(
                                `<div class="autocomplete-item" 
                                    data-name="${employee.full_name}" 
                                    data-email="${employee.email}" 
                                    data-division="${employee.division}">
                                    ${employee.full_name} (${employee.division})
                                </div>`
                            );
                        });
                    } else {
                        nameList.hide();
                    }
                }
            });
        } else {
            $('#nameList').hide();
        }
    });

    $(document).on('click', '.autocomplete-item', function () {
        let name = $(this).data('name');
        let email = $(this).data('email');
        let division = $(this).data('division');

        $('#name').val(name);
        $('#email').val(email);
        $('#division').val(division);
        $('#nameList').hide();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#name, #nameList').length) {
            $('#nameList').hide();
        }
    });

    // Message generation logic
    $('form').on('input', function () {
        let name = $('#name').val();
        let email = $('#email').val();
        let division = $('#division').val();
        let title = $('#title').val();
        let description = $('#message').val();
        let date = new Date().toLocaleDateString();

        let message = `
Kepada Bapak ${name},
Terima kasih telah mendaftarkan permintaan dukungan kepada Departemen IT. Kami senang dapat membantu anda dalam menyelesaikan berbagai masalah teknis dan dukungan yang dibutuhkan.
Berikut adalah detail registrasi Anda:

No. Registrasi          : 
Nama                    : ${name}
Email                   : ${email}
Departemen/Divisi       : ${division}
Jenis Permintaan        : ${title}

Tanggal Registrasi      : ${date}
Status                  : Open
Deskripsi Pekerjaan     :
${description}

Dengan registrasi ini, Anda akan mendapatkan akses ke berbagai layanan dukungan IT kami, termasuk:

1. Bantuan Teknis: Tim kami siap membantu Anda dalam menyelesaikan masalah teknis yang Anda alami.
2. Panduan dan Tutorial: Akses ke berbagai panduan dan tutorial untuk membantu Anda memahami dan menggunakan sistem dengan lebih baik.

Jika Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi kami melalui:
• Email: it-services@bai.id

Terima kasih atas kepercayaan Anda kepada kami. Kami berkomitmen untuk memberikan layanan terbaik kepada Anda.

Best Regards,

Information Technology Departement
📧 it-services@bai.id | 🌐 www.bai.id
        `;

        if (name && email && division && title && description) {
            $('#generatedMessage').show();
            $('#messageContent').text(message);
        } else {
            $('#generatedMessage').hide();
        }
    });
});
</script>

@endsection