$(function () {

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',

    });

    setTimeout(() => {
        $('.flash-status').remove()
    }, 3000);

    TableManageDefault.init();

    $('#uncheck').click(e => {
        $('input[type="checkbox"]').attr('checked', false)
    })

    $('.dropdown-toggle').dropdown()

    $('#validatedCustomFile').change((e) => {
        $('.custom-file-label').html(e.target.value)
    })

    $('a[aria-controls="data-table-default"]').click(() => {
        setTimeout(() => {
            $('.dropdown-toggle').dropdown()
        }, 500);

    })

    $("#preview_img").click(function () {
        $('#upload_img').click();
    });

    $("#upload_img").change(function () {
        readURL(this);
    });


    $('.image').click(e => {
        console.log('eee ', e.target.getAttribute('src'))
        $('#model_image_preview').modal()
        $('#image_preview').attr("src", e.target.getAttribute('src'))
    })
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


