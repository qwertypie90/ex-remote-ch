function getCookie(name) {
  const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
  return match ? match[2] : null;
}

function getTransactions(token) {
        const auth = token || getCookie("authToken");

            $.ajax({
            type: "POST",
            url: "proxy.php?command=Get",
            data: { authToken: token, returnValueList: "transactionList" },
            beforeSend: function() {
            // show loader, hide table while loading
            $("#loader").show();
            $("body").css("background-color", "white");
            },
            success: function(result) {
            console.log("Transactions:", result);
            // ✅ Render rows
            const tbody = $("#transactionTableBody");
            tbody.empty();
            if (result.transactionList) {
                result.transactionList.flat().forEach(transX => {
                tbody.append(`
                    <tr>
                    <td>${transX.created}</td>
                    <td>${transX.merchant}</td>
                    <td>${transX.amount / 100}</td>
                    </tr>
                            `);
                });
            }
            $("#transactionTable").show();
            $("#pic").show();
            },
            error: function(xhr, status, error) {
            console.error("transaction load failed 😢 ):", status, error);
            },
             complete: function() {
            // Hide loader, show table after request finishes
            $("#loader").hide();
            $("#transactionTable").show();
        }
        });
    };

    $('#modalForm').submit(function (e) {
            e.preventDefault();

            const date = $('#date').val();
            const merch = $('#merch').val();
            const amount = Math.round(parseFloat($('#amount').val()) * 100);
            const token = getCookie("authToken");

                if (!date || !merch || !amount) {
                $("#modal-text").text("All fields are required ❌");
                return;
    }

            console.log(`${date} and ${merch} and ${amount}`);

            var data = {
                date: date,
                merch: merch,
                amount: amount,
                authToken: token
            };
            console.log("UNserialized data:", data);

                $.ajax({
                    type: "POST",
                    url: "proxy.php?command=CreateTransaction",
                    data: data,
                    dataType: "json",
                    success: function(result) {
                       if (result.transactionList || result.accountID) {
                        const modalText = $("#modal-text");

                        // Save the original text
                        const originalText = modalText.text();

                        // Show success message
                        modalText.text("Submitted, queen ✅");

                        // After 5 seconds, restore the original text
                        setTimeout(function() {
                            modalText.text(originalText);
                        }, 5000);

                        // Refresh transactions
                        getTransactions(token);

                        // Clear form
                        $('#modalForm')[0].reset();
                    } else {
                        alert("Submit Failed, king: " + JSON.stringify(result));
                    }
                    },
                    error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    console.log("Response:", xhr.responseText);
                    }
                });
            });


    $(document).ready(function () {
        const token = getCookie("authToken");
        if (token) {
            console.log("Auth token found, skip login:", token);
            $("#loginContent").hide();
            getTransactions(token);
        } else {
            $("#loginContent").show();
            $("#transactionTable").hide();
        }

        const textContent = $('.textContent').text();

        $.validateEmail = function (email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
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
                    url: "proxy.php?command=Authenticate",
                    data: data,
                    dataType: "json",
                    success: function(result) {
                    if (result.authToken) {
                        console.log("Logged in:", result.authToken);
                        $.post("setCookie.php", { authToken: result.authToken });
                        $(".textContent").text("");
                        $("#loginContent").hide();
                        getTransactions(result.authToken);
                    } else {
                        alert("Login failed: " + JSON.stringify(result));
                    }
                    },
                    error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    console.log("Response:", xhr.responseText);
                    },
                });
            });
    });

    // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}