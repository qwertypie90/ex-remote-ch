$(document).ready(function () {
        const textContent = $('.textContent').text();

        $.validateEmail = function (email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         
        };

        $('#loginForm').submit(function (e) {
            e.preventDefault();
            $(".textContent").text("");

            const email = $('#email').val();
            const pass = $('#pass').val();
            $.validateEmail(`${email}`);

            const errorMessage = document.getElementById('error-message');
            if ($.validateEmail(email)) {
                $('.textContent').text('');
                alert('Email is valid! Form submitted.');
            } else {
                $('.textContent').text('Now... you know that is not an email, miss girl.');
            }
            console.log(`${email} and ${pass}`);
            var data = $(this).serialize();
            console.log("Serialized data:", data);

                $.ajax({
                    type: "POST",
                    url: "proxy.php",
                    data: data,
                    dataType: "json",
                    success: function(result) {
                    if (result.authToken) {
                        console.log("Logged in:", result.authToken);
                        $.post("setCookie.php", { authToken: result.authToken });
                        $(".textContent").text("");
                        $("#loginContent").hide();
                        $("#transactionTable").show();
                    } else {
                        alert("Login failed: " + JSON.stringify(result));
                    }
                    }
                });
            });
    });