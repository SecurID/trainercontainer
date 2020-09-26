const $tableID = $('#table');
const $BTN = $('#export-btn');

const newTr = `
<tr class="hide">
  <td class="pt-3-half" contenteditable="true"></td>
  <td class="pt-3-half" contenteditable="true" ></td>
  <td class="pt-3-half" contenteditable="true"></td>
  <td class="pt-3-half" contenteditable="true"></td>
  <td class="pt-3-half" contenteditable="true"></td>
  <td class="pt-3-half" contenteditable="true"></td>
  <td>
    <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">X</button></span>
  </td>
</tr>`;

$('.table-add').on('click', 'i', () => {
    $('tbody').append(newTr);
});

$tableID.on('click', '.table-remove', function () {

    $(this).parents('tr').detach();
});

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

$BTN.on('click', () => {

    const $rows = $tableID.find('tr:not(:hidden)');
    const headers = [];
    const data = [];

    // Get the headers (add special header logic here)
    $($rows.shift()).find('th:not(:empty)').each(function () {

        headers.push($(this).text().toLowerCase());
    });

    // Turn all existing rows into a loopable array
    $rows.each(function () {
        const $td = $(this).find('td');
        const h = {};

        // Use the headers from earlier to name our hash keys
        headers.forEach((header, i) => {

            h[header] = $td.eq(i).text();
        });

        data.push(h);
    });

    $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: "http://trainercontainer.test/practices",
        data: {
            data: data,
            date: new Date($('#date').val()),
            _token:  $('meta[name="csrf-token"]').attr('content'),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
        .done(function( msg){
            alert("Data Saved: "+msg);
        })

    console.log(JSON.stringify(data));
});

$( '.exercises' ).on("focus", function() {
        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "api/exercises",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        var resp = $.map(data, function (obj) {
                            //console.log(obj.city_name);
                            return obj.name;
                        });

                        response(resp);
                    }
                });
            },
            minLength: 2,
        })
    }
);

