<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body.dragging, body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        ol.example li.placeholder {
            position: relative;
            /** More li styles **/
        }
        ol.example li.placeholder:before {
            position: absolute;
            /** Define arrowhead **/
        }
    </style>
</head>
<body>
        <ol class='default vertical'>
                <li data-name="first" data-id="1">
                  First
                  <ol></ol>
                </li>
                <li>
                  Second
                  <ol></ol>
                </li>
                <li>
                  Third
                  <ol>
                    <li>First</li>
                    <li>Second</li>
                    <li>
                      Third
                      <ol>
                        <li>First</li>
                        <li>Second</li>
                        <li>First</li>
                        <li>Second</li>
                      </ol>
                    </li>
                  </ol>
                </li>
                <li>Fourth</li>
                <li>Fifth</li>
                <li>Sixth</li>
              </ol>
    {!! _load_js('/js/vendors/jquery-3.2.1.min.js') !!}
    {!! _load_js('/js/vendors/jquery-sortable.js') !!}
    <script>
        $(function  () {
            var group = $('ol.default').sortable({
                onDrop: function ($item, container, _super) {
                    var data = group.sortable("serialize").get();
                    var jsonString = JSON.stringify(data, null, ' ');
                    console.log(jsonString);
                    $('#serialize_output2').text(jsonString);
                    _super($item, container);
                }
            });
        });
    </script>
</body>
</html>