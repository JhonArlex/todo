$(document).ready(function () {
    $('input.autocomplete').autocomplete({
        data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'https://placehold.it/250x250'
        }
    })

    $("input.autocomplete").each(function () {
        let self = this;
        $(this).autocomplete();
        $(this).on("input", function (res) {
            $.ajax({
                url: 'http://127.0.0.1:8000/tareas/api/autocomplete',
                type: 'get',
                cache: false,
                data: { "word": res.target.value },
                success: function (data) {
                    data = JSON.parse(data);
                    const autoData = {};
                    for (const d of data.data) {
                        autoData[d.id + '-' + d.nombre] = null;
                    }
                    $(self).autocomplete("updateData", autoData);
                    $(self).autocomplete("open");
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });

    $(this).on("change", function (res) {
        const data = res.target.value;
        const id = data.split('-')[0];
        window.location.href = "/tareas/" + id;
    });
});

