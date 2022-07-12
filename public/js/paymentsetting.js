$(document).ready(function () {
    ChangeFormView();
    $(document).on('click', '#ProductionSandbox', function () {
        ChangeFormView();
        var set = $('#ProductionSandbox').is(':checked');
        var state = '1';
        if (set === false) {
            state = '0';
        }
        var csrf_token = $('#CheckBoxCSRF').val();
        $.ajax({
            type: "POST",
            url: ChangeState,
            data: {
                _token: csrf_token,
                gateway_name: 'stripe',
                production_enabled: state
            },
            success: function (data) {
                if (data == true) {
                    $('#SuccessBox').show();
                    setTimeout(function() {
                        $("#SuccessBox").hide()
                    }, 3000);
                }else {
                    $('#ErrorBox').show();
                    setTimeout(function() {
                        $("#ErrorBox").hide()
                    }, 3000);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr);
            }
        });
    });
    /*<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>*/
    function ChangeFormView() {
        var status = $('#ProductionSandbox').is(':checked');
        if (status === false) {
            //if status is false is setup in production mode.
            $('#sandbox').show();
            $('#production').hide();
        } else {
            $('#sandbox').hide();
            $('#production').show();
        }
    }

    $(document).on('click', '#productionSubmit', function () {
        var secret_key = $('#StripeProductionSecret').val();
        var show_key = $('#StripeProductionShow').val();
        var csrf_token = $('#production_csrf_token').val();
        $.ajax({
            type: "POST",
            url: SubmitURL,
            data: {
                _token: csrf_token,
                production_secret: secret_key,
                production_publishable: show_key,
                gateway_name: 'stripe',
                set: 'production'
            },
            success: function (data) {
                if (data == true) {
                    $('#SuccessBox').show();
                    setTimeout(function() {
                        $("#SuccessBox").hide()
                    }, 3000);
                }else {
                    $('#ErrorBox').show();
                    setTimeout(function() {
                        $("#ErrorBox").hide()
                    }, 3000);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr);
            }
        });
    });

    $(document).on('click', '#sandboxSubmit', function () {
        var secret_key = $('#SandBoxSecret').val();
        var show_key = $('#SandBoxShow').val();
        var csrf_token = $('#sandbox_csrf_token').val();
        $.ajax({
            type: "POST",
            url: SubmitURL,
            data: {
                _token: csrf_token,
                sandbox_secret: secret_key,
                sandbox_publishable: show_key,
                gateway_name: 'stripe',
                set: 'sandbox'
            },
            success: function (data) {
                if (data == true) {
                    $('#SuccessBox').show();
                    setTimeout(function() {
                        $("#SuccessBox").hide()
                    }, 3000);
                }else {
                    $('#ErrorBox').show();
                    setTimeout(function() {
                        $("#ErrorBox").hide()
                    }, 3000);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr);
            }
        });
    });
});


